<?php

namespace App\Services;

use App\Repositories\Interfaces\MainRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestMail;

class MainService
{
    private $mainRepository;
    private $s3_icons_fd;

    /**
     * MainService constructor.
     *
     * @param MainRepositoryInterface $mainRepository
     */
    public function __construct(MainRepositoryInterface $mainRepository)
    {
        $this->s3_icons_fd = config('awsconfig.s3_folder.icons');
        $this->mainRepository = $mainRepository;
    }

    /**
     * 올바른 m_id(member id)인지 검증
     *
     * @param string $m_id member id
     *
     * @return bool
     */
    public function validMid($m_id)
    {
        $result = false;

        if ($this->mainRepository->countResume($m_id) == 1) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Resume 정보를 리턴
     *
     * @param string $m_id member id
     *
     * @return array
     */
    public function resumeData($m_id)
    {
        return $this->mainRepository->findResume($m_id);
    }

    /**
     * Resume용 이미지를 리턴
     *
     * @param string $m_id member id
     *
     * @return array
     */
    private function resumeImagesData($m_id)
    {
        return $this->mainRepository->findResumeImages($m_id);
    }

    /**
     * Resume용 이미지를 array로 리턴
     *
     * @param array $imagesData
     *
     * @return array
     */
    private function imagesArray($imagesData) {
        $stJsonData = array();
        $pgJsonData = array();
        $apJsonData = array();
        $tlJsonData = array();
        $wsJsonData = array();

        foreach($imagesData as $val) {
            if($val->RI_TYPE === 'ST') {
                $stJsonData[] = array(
                    "img_ty" => $val->RI_TYPE,
                    "img_nm" => $val->RI_IMG_NM,
                    "img_uri" => Storage::disk('s3')->url($this->s3_icons_fd.'/'.$val->RI_URI),
                );
            } elseif($val->RI_TYPE === 'PG') {
                $pgJsonData[] = array(
                    "img_ty" => $val->RI_TYPE,
                    "img_nm" => $val->RI_IMG_NM,
                    "img_uri" => Storage::disk('s3')->url($this->s3_icons_fd.'/'.$val->RI_URI),
                );
            } elseif($val->RI_TYPE === 'AP') {
                $apJsonData[] = array(
                    "img_ty" => $val->RI_TYPE,
                    "img_nm" => $val->RI_IMG_NM,
                    "img_uri" => Storage::disk('s3')->url($this->s3_icons_fd.'/'.$val->RI_URI),
                );
            } elseif($val->RI_TYPE === 'TL') {
                $tlJsonData[] = array(
                    "img_ty" => $val->RI_TYPE,
                    "img_nm" => $val->RI_IMG_NM,
                    "img_uri" => Storage::disk('s3')->url($this->s3_icons_fd.'/'.$val->RI_URI),
                );
            } elseif($val->RI_TYPE === 'WS') {
                $wsJsonData[] = array(
                    "img_ty" => $val->RI_TYPE,
                    "img_nm" => $val->RI_IMG_NM,
                    "img_uri" => Storage::disk('s3')->url($this->s3_icons_fd.'/'.$val->RI_URI),
                );
            }
        }

        $result = array(
            "st" => $stJsonData,
            "pg" => $pgJsonData,
            "ap" => $apJsonData,
            "tl" => $tlJsonData,
            "ws" => $wsJsonData,
        );

        return $result;
    }

    /**
     * Resume용 이미지를 array로 리턴
     *
     * @param string $m_id member id
     *
     * @return array
     */
    public function resumeJsonData($m_id)
    {
        $resumeData = $this->resumeData($m_id);
        $resumeImageData = $this->resumeImagesData($m_id);
        $imageArray = $this->imagesArray($resumeImageData);

        $jsonFormat = array(
            "name_kr" => $resumeData->M_NAME_KR,
            "name_en" => $resumeData->M_NAME_EN,
            "birth" => $resumeData->M_BIRTH,
            "degree" => $resumeData->M_DEGREE,
            "crtfi_kr" => $resumeData->M_CRTFI_KR,
            "crtfi_en" => $resumeData->M_CRTFI_EN,
            "ofln" => $resumeData->M_OFLN,
            "images" => $imageArray,
        );

        return $jsonFormat;
    }

    /**
     * 경력정보를 array로 리턴
     *
     * @param string $m_id member id
     *
     * @return array
     */
    public function worksData($m_id)
    {
        return $this->mainRepository->findWorks($m_id);
    }

    /**
     * 경력정보용 이미지를 array로 리턴
     *
     * @param string $m_id member id
     * @param string $w_id works id
     *
     * @return array
     */
    private function worksImagesData($m_id, $w_id)
    {
        return $this->mainRepository->findWorksImages($m_id, $w_id);
    }

    /**
     * 경력정보 디테일 정보를 array로 리턴
     *
     * @param string $m_id member id
     * @param string $w_id works id
     *
     * @return array
     */
    private function worksDetailsData($m_id, $w_id)
    {
        return $this->mainRepository->findWorksDetails($m_id, $w_id);
    }

    /**
     * 경력정보 데이터를 array로 리턴
     *
     * @param string $m_id member id
     *
     * @return array
     */
    public function worksJsonData($m_id)
    {
        $worksData = $this->worksData($m_id);

        $wdJsonData = array();
        $wdJsonData = array();
        foreach ($worksData as $valws) {
            $worksDetailsData = $this->worksDetailsData($m_id, $valws->W_ID);
            foreach ($worksDetailsData as $valwd) {
                $wdJsonData[] = array(
                    "prj_ti" => $valwd->WD_PRJ_TI,
                    "prj_dt" => $valwd->WD_PRJ_DT,
                );
            }

            $worksImageData = $this->worksImagesData($m_id, $valws->W_ID);
            $imageArray = $this->imagesArray($worksImageData);

            $jsonFormat[] = array(
                "cmp_nm" => $valws->W_CMP_NM,
                "cmp_cnty" => $valws->W_CMP_CN_NM,
                "cmp_cnty_img" => array(
                    "img_ty" => $valws->RI_TYPE,
                    "img_nm" => $valws->RI_IMG_NM,
                    "img_uri" => Storage::disk('s3')->url($this->s3_icons_fd.'/'.$valws->RI_URI),
                ),
                "cmp_job_ti" => $valws->W_CMP_JOB,
                "cmp_job_pst" => $valws->W_CMP_JOB_TI,
                "cmp_perd" => $valws->W_CMP_PERD,
                "images" => $imageArray,
                "details" => $wdJsonData,
            );
            unset($wdJsonData);
        }

        return $jsonFormat;
    }

    /**
     * 문의 메일 정보 로직
     *
     * @param string $sender_name 보내는 사람 이름
     * @param string $sender_email 보내는 사람 이메일
     * @param string $subject 제목
     * @param string $contents 내용
     *
     * @return array $result {
     *      @type bool status 메일 전송 결과를 true|false로 리턴
     *      @type string err_msg status가 false일시에 오류 메세지를 리턴
     * }
     */
    public function sendRequestMail($sender_name, $sender_email, $subject, $contents)
    {
        $result['status'] = false;

        try {
            Mail::to('tanreen1@gmail.com')
                ->send(new RequestMail($sender_name, $sender_email, $subject, $contents));

            $result['status'] = true;
        } catch (\Exception $e) {
            $result['status'] = false;
            $result['err_msg'] = $e->getMessage();
        }

        return $result;
    }
}
