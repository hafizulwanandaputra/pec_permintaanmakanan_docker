<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Auth extends BaseController
{
    protected $AuthModel;
    public function __construct()
    {
        $this->AuthModel = new AuthModel();
    }

    public function index()
    {
        $users = $this->AuthModel->orderBy('username', 'ASC')->findAll();
        $data = [
            'users' => $users,
            'agent' => $this->request->getUserAgent()
        ];
        return view('auth/login', $data);
    }

    public function check_login()
    {
        if (!$this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required!'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required!'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }
        $username = $this->request->getPost('username');
        $password = $this->request->getVar('password');
        $url = $this->request->getVar('url');
        $check = $this->AuthModel->login($username);
        if ($check) {
            if (password_verify($password, $check['password'])) {
                session()->set('log', true);
                session()->set('id_user', $check['id_user']);
                session()->set('fullname', $check['fullname']);
                session()->set('username', $check['username']);
                session()->set('password', $check['password']);
                session()->set('profilephoto', $check['profilephoto']);
                session()->set('role', $check['role']);
                session()->set('url', $url);
                $db = db_connect();
                $agent = $this->request->getUserAgent();
                if ($agent->isRobot() == FALSE) {
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if ($agent->isMobile()) {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Login", "' . $useragent . '", UTC_TIMESTAMP())');
                    } else {
                        $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Login", "' . $useragent . '", UTC_TIMESTAMP())');
                    }
                }
                return redirect()->to($url);
            } else {
                session()->setFlashdata('error', 'Wrong password!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Username not registered!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        $db = db_connect();
        $agent = $this->request->getUserAgent();
        if ($agent->isRobot() == FALSE) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if ($agent->isMobile()) {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", "' . $agent->getMobile() . '", "Logout", "' . $useragent . '", UTC_TIMESTAMP())');
            } else {
                $db->query('INSERT INTO `session_history` (`username`, `ipaddress`, `os`, `browser`, `mobile`, `activity`, `useragent`, `datetime`) VALUES ("' . session()->get('username') . '", "' . $ipaddress . '", "' . $agent->getPlatform() . '", "' . $agent->getBrowser() . ' ' . $agent->getVersion() . '", NULL, "Logout", "' . $useragent . '", UTC_TIMESTAMP())');
            }
        }
        session()->remove('log');
        session()->remove('id_user');
        session()->remove('fullname');
        session()->remove('username');
        session()->remove('password');
        session()->remove('profilephoto');
        session()->remove('role');
        session()->remove('url');
        session()->setFlashdata('msg', 'Logout successful! Thank you!');
        return redirect()->to(base_url());
    }
}
