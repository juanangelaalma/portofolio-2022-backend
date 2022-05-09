<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectsController extends Controller
{
    public function index() {
        return Projects::all();
    }

    public function store(Request $request) {
        
    }

    public function update() {
        return 'update project';
    }

    public function destroy() {
        return 'destroy project';
    }
}
    