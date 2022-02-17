<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Blog;

class BlogController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $blogModel = model(Blog::class);
        $blogs['blogs'] = $blogModel->findAll();

        if (!$blogs == null) {
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

        $rules = [
            'blog_title' => 'required',
            'blog_description' => 'required',
        ];

        $massages = [
            'title' => [
                'required' => 'Title is required'
            ],
            'description' => [
                'required' => 'Description is required'
            ],
        ];

        $file = $this->request->getFile('image');
        $blogImage = $file->getName();

        $temp = explode(".", $blogImage);
        $newFileName = round(microtime(true)) . '.' . end($temp);

        if (!$this->validate($rules, $massages)) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors()
            ];
        } else {
            
            $file->move('./uploads', $newFileName);

            $data = [
                'blog_title' => $this->request->getVar('blog_title'),
                'blog_description' => $this->request->getVar('blog_description'),
                'file_name' => $newFileName,
                'file_path' => "/blog/" . $newFileName
            ];

            if ($blogModel->insert($data)) {
                
                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'Successfully, blog has been created!'
                    ]
                ];
            } else {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'Failed to create blog!'
                ];
            }
        }

        return $this->respond($response);
    }

    public function show($id = null)
    {

        $blogModel = model(Blog::class);
        $blogs = $blogModel->where('id', $id)->first();

        if ($blogs) {

            $response = [
                'status' => 200,
                'error' => null,
                'data' => $blogs,
                'messages' => [
                    'success' => 'Blogs find!'
                ]
            ];

            return $this->respond($response);
        } else {
            return $this->failNotFound('Blog dosen`t find!');
        }
    }

    public function update($id = null)
    {

        $blogModel = model(Blog::class);
        $blogs = $blogModel->where('id', $id)->first();

        $rules = [
            'blog_title' => 'required',
            'blog_description' => 'required',
        ];

        $massages = [
            'title' => [
                'required' => 'Title is required'
            ],
            'description' => [
                'required' => 'Description is required'
            ],
        ];
        
        $file = $this->request->getFile('image');
        $blogImage = $file->getName();

        $temp = explode(".", $blogImage);
        $newFileName = round(microtime(true)) . '.' . end($temp);

        if (!$this->validate($rules, $massages)) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors()
            ];
        } else {
            $file->move('./uploads', $newFileName);

            $data = [
                'blog_title' => $this->request->getVar('blog_title'),
                'blog_description' => $this->request->getVar('blog_description'),
                'file_name' => $newFileName,
                'file_path' => "/blog/" . $newFileName
            ];

            if ($blogModel->update($id, $data)) {
                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'Successfully, blog has been updated!'
                    ]
                ];
            } else {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'Failed to update blog!'
                ];
            }
        }

        return $this->respond($response);
    }

    public function delete($id = null)
    {

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
