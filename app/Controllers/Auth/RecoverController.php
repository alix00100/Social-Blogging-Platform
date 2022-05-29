<?php

namespace App\Controllers\Auth;

use Hleb\Constructor\Handlers\Request;
use App\Controllers\Controller;
use App\Models\User\{SettingModel, UserModel};
use Integration, Validation, SendEmail, Meta, Html, Msg, UserData;

class RecoverController extends Controller
{
    public function showPasswordForm()
    {
        $m = [
            'og'    => false,
            'url'   => url('recover'),
        ];

        return $this->render(
            '/auth/recover',
            'base',
            [
                'meta'  => Meta::get(__('app.password_recovery'), __('app.recover_info'), $m),
                'data'  => [
                    'sheet' => 'recover',
                    'type'  => 'recover',
                ]
            ]
        );
    }

    public function index()
    {
        $email      = Request::getPost('email');
        $redirect   = url('recover');

        if (config('general.captcha')) {
            if (!Integration::checkCaptchaCode()) {
                Validation::comingBack('msg.code_error', 'error', $redirect);
            }
        }

        Validation::email($email = Request::getPost('email'), $redirect);

        $uInfo = UserModel::userInfo($email);

        if (empty($uInfo['email'])) {
            Validation::comingBack('msg.no_user', 'error', $redirect);
        }

        // Проверка на заблокированный аккаунт
        if ($uInfo['ban_list'] == UserData::BANNED_USER) {
            Validation::comingBack('msg.account_verified', 'error', $redirect);
        }

        $code = $uInfo['id'] . '-' . Html::randomString('crypto', 25);
        UserModel::initRecover(
            [
                'activate_date'     => date('Y-m-d H:i:s'),
                'activate_user_id'  => $uInfo['id'],
                'activate_code'     => $code,
            ]
        );

        // Отправка e-mail
        SendEmail::mailText($uInfo['id'], 'changing.password', ['newpass_link' => url('recover.code', ['code' => $code])]);

        Validation::comingBack(__('msg.successfully'), url('login'));
    }

    // Страница установки нового пароля
    public function showRemindForm()
    {
        $code       = Request::get('code');
        $user_id    = UserModel::getPasswordActivate($code);

        if (!$user_id) {
            Msg::add(__('msg.went_wrong'), 'error');
            redirect(url('login'));
        }

        $user = UserModel::getUser($user_id['activate_user_id'], 'id');
        self::error404($user);

        return $this->render(
            '/auth/newrecover',
            'base',
            [
                'meta'  => Meta::get(__('app.password recovery'), __('app.recover_info')),
                'data'  => [
                    'code'      => $code,
                    'user_id'   => $user_id['activate_user_id'],
                    'sheet'     => 'recovery',
                    'type'      => 'newrecover',
                ]
            ]
        );
    }

    public function remindNew()
    {
        $password   = Request::getPost('password');
        $code       = Request::getPost('code');
        $user_id    = Request::getPost('user_id');

        if (!$user_id) {
            return false;
        }

        Validation::length($password, 8, 32, 'password', url('recover.code', ['code' => $code]));

        $newpass  = password_hash($password, PASSWORD_BCRYPT);
        SettingModel::editPassword(['id' => $user_id, 'password' => $newpass]);

        UserModel::editRecoverFlag($user_id);

        Validation::comingBack(__('msg.change_saved'), 'success', url('login'));
    }

    // Проверка корректности E-mail
    public function ActivateEmail()
    {
        $code = Request::get('code');
        $activate_email = UserModel::getEmailActivate($code);

        if (!$activate_email) {
            Msg::add(__('msg.code_incorrect'), 'error');
            redirect('/');
        }

        UserModel::EmailActivate($activate_email['user_id']);

        Msg::add(__('msg.yes_email_pass'), 'success');
        redirect(url('login'));
    }
}
