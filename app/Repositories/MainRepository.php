<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MainRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Main;

class MainRepository extends BaseRepository implements MainRepositoryInterface
{
    /**
     * MainRepository constructor.
     *
     * @param Main $model
     */
    public function __construct(Main $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $m_id member id
     *
     * @return array
     */
    public function countResume($m_id)
    {
        return $this->model->where('M_ID', $m_id)->count();
    }

    /**
     * @param string $m_id member id
     *
     * @return array
     */
    public function findResume($m_id)
    {
        return $this->model->where('M_ID', $m_id)->first();
    }

    /**
     * @param string $m_id member id
     *
     * @return array
     */
    public function findResumeImages($m_id)
    {
        $result = DB::table('TBL_MAIN')
            ->join('TBL_RESM_IMAGE', 'TBL_MAIN.M_ID', '=', 'TBL_RESM_IMAGE.M_ID')
            ->select('TBL_RESM_IMAGE.RI_ID', 'TBL_RESM_IMAGE.RI_TYPE', 'TBL_RESM_IMAGE.RI_IMG_NM', 'TBL_RESM_IMAGE.RI_URI')
            ->where([
                ['TBL_MAIN.M_ID', $m_id],
                ['TBL_RESM_IMAGE.RI_STATUS', 'A'],
                ['TBL_RESM_IMAGE.RI_TYPE', '<>', 'CN'],
            ])
            ->orderBy('TBL_RESM_IMAGE.RI_TYPE', 'ASC')
            ->orderBy('TBL_RESM_IMAGE.RI_SORT', 'ASC')
            ->get();

        return $result;
    }

    /**
     * @param string $m_id member id
     *
     * @return array
     */
    public function findWorks($m_id)
    {
        $result = DB::table('TBL_MAIN')
            ->join('TBL_WORK', 'TBL_MAIN.M_ID', '=', 'TBL_WORK.M_ID')
            ->join('TBL_RESM_IMAGE', 'TBL_WORK.RI_ID', '=', 'TBL_RESM_IMAGE.RI_ID')
            ->select(
                'TBL_MAIN.M_ID', 'TBL_WORK.W_ID', 'TBL_WORK.W_CMP_NM', 'TBL_WORK.W_CMP_CN_NM', 'TBL_WORK.W_CMP_JOB', 'TBL_WORK.W_CMP_PERD', 'TBL_WORK.W_CMP_JOB_TI',
                'TBL_RESM_IMAGE.RI_ID', 'TBL_RESM_IMAGE.RI_TYPE', 'TBL_RESM_IMAGE.RI_IMG_NM', 'TBL_RESM_IMAGE.RI_URI'
            )
            ->where([
                ['TBL_MAIN.M_ID', $m_id],
                ['TBL_RESM_IMAGE.RI_STATUS', 'A'],
            ])
            ->get();

        return $result;
    }

    /**
     * @param string $m_id member id
     * @param string $w_id works id
     *
     * @return array
     */
    public function findWorksImages($m_id, $w_id)
    {
        $result = DB::table('TBL_MAIN')
            ->join('TBL_WORK', 'TBL_MAIN.M_ID', '=', 'TBL_WORK.M_ID')
            ->join('TBL_WORK_IMAGES', 'TBL_WORK.W_ID', '=', 'TBL_WORK_IMAGES.W_ID')
            ->join('TBL_RESM_IMAGE', 'TBL_WORK_IMAGES.RI_ID', '=', 'TBL_RESM_IMAGE.RI_ID')
            ->select('TBL_MAIN.M_ID', 'TBL_WORK.W_ID', 'TBL_RESM_IMAGE.RI_ID', 'TBL_RESM_IMAGE.RI_TYPE', 'TBL_RESM_IMAGE.RI_IMG_NM', 'TBL_RESM_IMAGE.RI_URI')
            ->where([
                ['TBL_MAIN.M_ID', $m_id],
                ['TBL_WORK.W_ID', $w_id],
                ['TBL_RESM_IMAGE.RI_STATUS', 'A'],
            ])
            ->orderBy('TBL_WORK_IMAGES.WI_SORT', 'ASC')
            ->get();

        return $result;
    }

    /**
     * @param string $m_id member id
     * @param string $w_id works id
     *
     * @return array
     */
    public function findWorksDetails($m_id, $w_id)
    {
        $result = DB::table('TBL_MAIN')
            ->join('TBL_WORK', 'TBL_MAIN.M_ID', '=', 'TBL_WORK.M_ID')
            ->join('TBL_WORK_DT', 'TBL_WORK.W_ID', '=', 'TBL_WORK_DT.W_ID')
            ->select('TBL_MAIN.M_ID', 'TBL_WORK.W_ID', 'TBL_WORK_DT.WD_PRJ_TI', 'TBL_WORK_DT.WD_PRJ_DT')
            ->where([
                ['TBL_MAIN.M_ID', $m_id],
                ['TBL_WORK.W_ID', $w_id],
            ])
            ->get();

        return $result;
    }
}
