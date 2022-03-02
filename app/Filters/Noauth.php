<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Noauth implements FilterInterface
{
    use ResponseTrait;
   
    public function before(RequestInterface $request, $arguments = null)
    {
        if(session()->get('isLoggedIn')){

            if (session()->get('role') == 'admin') {
                $response = [
                    'status'    => 200,
                    'error'     => false,
                    'messages'  => 'Admin logged in successfully',
                ];

                return $this->respondCreated($response);
            }

            if (session()->get('role') == 'user') {	
                $response = [
                    'status'    => 200,
                    'error'     => false,
                    'messages'  => 'User logged in successfully',
                ];

                return $this->respondCreated($response);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
