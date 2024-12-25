<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Start session and check if the user is logged in
        $session = Services::session();

        // Check if session contains user data (adjust according to your session structure)
        if (!$session->get('user_id')) {
            // Redirect to login page if not logged in
            return redirect()->to(base_url("/"));
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after-action needed for login checking
        $session = Services::session();
        $this->userid = $session->get('user_id')['id'];
    }
}