<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    public function index()
    {
        return Projects::all();
    }

    public function store(Request $request)
    {
        // request validator
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'description'   => 'required',
            'url'           => 'required',
            'github_url'    => 'required',
            'thumbnail'     => 'required|mimes:jpg,png,jpeg,webp'
        ]);

        // if validation is not fullfiled
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // store thumbnail to public/images/project
        $upload_image = $request->file('thumbnail')->store("public/images/project");

        // create new peoject
        $new_project = Projects::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'url'           => $request->url,
            'github_url'    => $request->github_url,
            'thumbnail'     => $request->file('thumbnail')->hashName(),
        ]);

        // return response
        return response()->json(['message' => 'new project is created', 'data' => $new_project], 201);
    }

    public function update(Request $request, $id)
    {
        // request validator
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'description'   => 'required',
            'url'           => 'required',
            'github_url'    => 'required'
        ]);

        // if validation is not fullfiled
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // find existing project by id 
        $project = Projects::find($id);

        // if project with the id not found
        if(!$project) {
            return response()->json(["message" => "id $id not found"], 404);
        }

        // if request has new thumbnail
        if ($request->file('thumbnail')) {
            $path = 'public/images/project/' . $project->thumbnail;
            // if current thumbnail is not empty
            if (Storage::exists($path)) {
                // current thumbnail will be deleted
                Storage::delete($path);
            }
            // store the new thumbnail
            $request->file('thumbnail')->store('public/images/project');
            // save the new thumbnail filename to database
            $project->thumbnail = $request->file('thumbnail')->hashName();
        }

        // update data
        $project->title         = $request->title;
        $project->description   = $request->description;
        $project->url           = $request->url;
        $project->github_url    = $request->github_url;
        $project->save();

        // return response success
        return response()->json(["message" => "project updated successfully", "data" => $project], 200);
    }

    public function destroy($id)
    {
        $project = Projects::find($id);
        
        if(!$project) {
            return response()->json(["message" => "id $id not found"], 404);
        } 

        $path = "public/images/project/" . $project->thumbnail;

        if(Storage::exists($path)) {
            Storage::delete($path);
        }

        Projects::destroy($id);

        return response()->json(["message" => "project deleted successfully"], 200);
    }
}
