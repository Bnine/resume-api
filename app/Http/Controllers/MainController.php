<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainIdRequest;
use App\Http\Requests\RequestMailPost;
use App\Services\MainService;

class MainController extends Controller
{
    private $mainService;

    /**
     * MainController constructor.
     *
     * @param MainService $mainService
     */
    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    /**
     * Resume 정보를 Json으로 리턴
     *
     * @param array $request {
     *     @type string m_id m_id(member id)를 이용하여 각종 정보를 조회함
     * }
     *
     * @return string JSON
     * @link https://app.swaggerhub.com/apis-docs/Bnine/Bnine-resume-api/1.0.0#/resume/get_api_v1_profile__m_id_
     */
    public function index(MainIdRequest $request)
    {
        $validated = $request->validated();

        if (!$this->mainService->validMid($request->m_id)) {
            return response()->json(['message' => 'Invalid m_id data'], 400);
        }

        $jsonFormat = $this->mainService->resumeJsonData($request->m_id);

        return response()->json($jsonFormat, 200);
    }

    /**
     * Resume 경력정보를 Json으로 리턴
     *
     * @param array $request {
     *     @type string m_id m_id(member id)를 이용하여 각종 정보를 조회함
     * }
     *
     * @return string JSON
     * @link https://app.swaggerhub.com/apis-docs/Bnine/Bnine-resume-api/1.0.0#/resume/get_api_v1_work_experience__m_id_
     */
    public function workExpcn(MainIdRequest $request)
    {
        $validated = $request->validated();

        if (!$this->mainService->validMid($request->m_id)) {
            return response()->json(['message' => 'Invalid m_id data'], 400);
        }

        $jsonFormat = $this->mainService->worksJsonData($request->m_id);

        return response()->json($jsonFormat, 200);
    }

    /**
     * 문의 메일 관련 처리
     *
     * @param array $request {
     *     @type string sender_name 보내는 사람 이름
     *     @type string sender_email 보내는 사람 이메일
     *     @type string subject 제목
     *     @type string contents 내용
     * }
     *
     * @return string JSON
     * @link https://app.swaggerhub.com/apis-docs/Bnine/Bnine-resume-api/1.0.0#/resume/post_api_v1_email
     */
    public function sendRequestMail(RequestMailPost $request)
    {
        $validated = $request->validated();

        $result = $this->mainService->sendRequestMail($request->sender_name, $request->sender_email, $request->subject, $request->contents);

        if ($result['status']) {
            return response()->json(['message' => '전송에 성공 하였습니다'], 200);
        } else {
            return response()->json(['message' => '전송에 실패 하였습니다'], 200);
        }
    }
}
