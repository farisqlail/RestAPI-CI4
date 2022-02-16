<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use \Firebase\JWT\JWT;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]|min_length[6]',
            'phone_no' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'name' => [
                'required' => 'Name is required'
            ],
            'email' => [
                'required' => 'Email is required',
                'valid_email' => 'Email address is not in format'
            ],
            'phone_no' => [
                'required' => 'Phone number is required'
            ],
            'password' => 'Password is required'
        ];

        if (!$this->validate($rules, $messages)) {

            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getError()
            ];
        } else {

            $userModel = new User();

            $data = [
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'phone_no' => $this->request->getVar('phone_no'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ];

            if ($userModel->insert($data)) {

                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'Successfully, user has been registered!'
                    ]
                ];
            } else {

                $response = [
                    'status' => 500,
                    'error' => null,
                    'messages' => [
                        'success' => 'Failed to create account!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    private function getKey()
    {

        return "application_secret";
    }

    public function login()
    {

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        $messages = [
            'email' => [
                'required' => 'Email required',
                'valid_email' => 'Email addresss is not in format'
            ],
            'password' => [
                'required' => 'Password is required'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getError()
            ];

            return $this->respondCreated($response);

        } else {

            $userModel = new User();

            $useData = $userModel->where('email', $this->request->getVar('email'))->first();

            if (!empty($userData)) {
                
                if (password_verify($this->request->getVar('password'), $useData['password'])) {
                    
                    $key = $this->getKey();

                    $iat = time();
                    $nbf = $iat + 10;
                    $exp = $iat + 3600;

                    $payload = array(
                        'iss' => 'The_claim',
                        'aud' => 'The_aud',
                        'iat' => $iat,
                        'nbf' => $nbf,
                        'exp' => $exp,
                        'data' => $userData
                    );

                    $token = JWT::encode($payload, $key);

                    $response = [
                        'status' => 200,
                        'error' => null,
                        'messages' => 'User logged in successfully',
                        'data' => [
                            'token' => $token
                        ]
                    ];

                    return $this->respondCreated($response);
                } else {

                    $response = [
                        'status' => 500,
                        'error' => null,
                        'messages' => 'Inccorect details'
                    ];

                    return $this->respondCreated($response);
                }                   
            } else {

                $response = [
                    'status' => 500,
                    'error' => null,
                    'messages' => 'User not found'
                ];

                return $this->respondCreated($response);
            }
        }
    }
}
