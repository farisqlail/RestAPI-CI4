<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Blog;

class BlogController extends BaseController
{
    use ResponseTrait;
    
    public function index()
    {
        $blogModel = model(Blog::class);
        $blogs['blogs'] = $blogModel->findAll();

        if (!$blogs === null) {
            $response = [
                'status' => 200,
                'error' => null,
                'data' => $blogs,
                'messages' => [
                    'success' => 'List Blogs!'
                ]
            ];
    
            // echo view('blog/index', $blogs);
            return $this->respond($response);
        } else {
            return $this->failNotFound('Blog dosen`t find!');
        }
        
    }

    public function create()
    {

        $blogModel = model(Blog::class);

        // if ($this->request->getMethod() === 'post' && $this->validate([
        //     'blog_title' => 'required',
        //     'blog_description' => 'required'
        // ])) {
            $data = [
                'blog_title' => $this->request->getVar('blog_title'),
                'blog_description' => $this->request->getVar('blog_description')
            ];

            $blogModel->insert($data);
            
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Blog successfully created!'
                ]
            ];

            return $this->respondCreated($response);
        // }
    }

    public function show($id = null){
        
        $blogModel = model(Blog::class);
        $blogs = $blogModel->where('blog_id', $id)->first();

        if ($blogs) {
            return $this->respond($blogs);
        } else {
            return $this->failNotFound('Blog dosen`t find!');
        }
    }

    public function update($id = null){

        $blogModel = model(Blog::class);
        // $id = $this->request->getVar('id');
        $blogs = $blogModel->where('id', $id)->first();

        $data = [
            'blog_title' => $this->request->getVar('blog_title'),
            'blog_description' => $this->request->getVar('blog_description')
        ];

        $blogModel->update($id, $data);
            
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Blog successfully updated!'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($id = null){

        $blogModel = model(Blog::class);
        $blogs = $blogModel->where('id', $id)->first();

        if ($blogs) {
            $blogModel->delete($id);

            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Blog successfully deleted!'
                ]
            ];
    
            return $this->respond($response);
        } else {
            return $this->failNotFound('Blog dosen`t find!');
        }
    }
}
