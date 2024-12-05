<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Constants\ErrCode;
use App\Exception\BusinessException;
use App\JsonRpc\UserCenter\Contracts\UserCenterInterface;
use App\Model\Model;
use App\Model\User;
use App\Utils\ResponseUtil;
use Hyperf\ApiDocs\Annotation\ApiOperation;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\AuthMiddleware;
use function App\Kernel\console;
use function App\Kernel\logger;

#[Controller(prefix: '/user')]
class IndexController extends AbstractController
{
    #[Inject]
    protected UserCenterInterface $userCenter;

    #[GetMapping(path: 'index')]
    public function index()
    {
        console()->debug('debug ----- Hello Hyperf!');
        console()->info('info ----- Hello Hyperf!');
        console()->warning('warning ----- Hello Hyperf!');
        console()->alert('alert ----- Hello Hyperf!');
        console()->critical('critical ----- Hello Hyperf!');
        console()->error('error ----- Hello Hyperf!');
        console()->emergency('emergency ----- Hello Hyperf!');
        console()->notice('notice ----- Hello Hyperf!');
        logger()->info('info ----- Hello Hyperf!');
        throw new BusinessException(ErrCode::SERVER_ERROR);
        return ResponseUtil::success(['count' => 1]);
    }

    #[GetMapping(path: 'user')]
    #[Middleware(AuthMiddleware::class)]
    #[ApiOperation(summary: '获取用户信息', description: '获取用户信息', )]
    public function user(): ResponseInterface
    {
        User::where('id', 1)->first();
        $id = $this->request->input('id');
        $user = $this->userCenter->getUserInfo((int)$id);
        return ResponseUtil::success($user);
    }

    #[PostMapping(path: 'login')]
    #[ApiOperation(summary: '用户登录', description: '用户登录')]
    public function login()
    {
        $user = User::retrieveById(1);
        $token = auth()->login($user);
        return ResponseUtil::success(['token' => $token]);
    }
}
