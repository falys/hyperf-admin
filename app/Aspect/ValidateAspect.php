<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/26/20
 * Time: 5:22 PM
 */

namespace App\Aspect;


use App\Annotations\Validation;
use App\Exception\ValidateException;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ValidateAspect
 * @Aspect()
 */
class ValidateAspect extends AbstractAspect
{
    protected $container;
    protected $request;
    protected $response;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request   = $this->container->get(RequestInterface::class);
        $this->response  = $this->container->get(ResponseInterface::class);
    }

    //要切入的类
    public $annotations=[
        Validation::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed|void
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        foreach ($proceedingJoinPoint->getAnnotationMetadata()->method as $validation) {
            if( $validation instanceof Validation) {
                if (!empty($validation->mode)) {
                    $name = $validation->mode;
                } else {
                    throw new ValidateException('mode 不能为空');
                }
                $verData = $this->request->all();
                $result  = $this->validateData($validation, $verData, $name, $proceedingJoinPoint, true);
                if($result){
                    return $this->response->json(['code'=> '-1',"message"=>$result,'data'=> []]);
                }
            }
        }
        $result = $proceedingJoinPoint->process();
        // 在调用后进行某些处理
        return $result;
    }

    /**
     * @param $validation
     * @param $data
     * @param $name
     * @param $proceedingJoinPoint
     * @return \Psr\Http\Message\ResponseInterface
     * @throws ValidateException
     */
    public function validateData($validation, $data, $name, $proceedingJoinPoint) {
        $result = "";
        $class = 'app\\Validation\\'.$name.'Validation';
        if(class_exists($class)) {
            $validate = new $class;
        } else {
            throw new ValidateException('class not exists:' . $class);
        }
        if($validation->scene == '') {
            $validation->scene = $proceedingJoinPoint->methodName;
        }

        if (!$validate->scene($validation->scene)->check($data)){
            $result = $validate->getError();
        }
        return $result;
    }
}