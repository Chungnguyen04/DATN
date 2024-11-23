<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with([
            'user',
            'product'
        ])->latest()->paginate(10);
        return view('admin.pages.comment.index',compact('comments'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id);
        $commentById = Comment::with([
            'user',
            'product'
        ])->where('id',$id)->first();
        return view('admin.pages.comment.edit',compact('commentById','comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // $data = [
        //     'rating' => $request->rating,
        //     'status' => $request->status
        // ];
        $comment->update($request->all());
        return redirect()->route('comments.index')->with('success','Sửa thành công');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
