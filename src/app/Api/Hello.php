<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\Pro\Pro as ProDomain;

/**
 * 币种信息
 */
class Hello extends Api {
	protected $profile = array();

	public function getRules() {
        return array(
            'getProinfo' => array(
                'pid' => array('name' => 'pid', 'require' => true, 'desc' => '币种ID需要唯一'),
            ),
        );
    }
	/**
	 * 币种信息接口
	 * @desc 根据pid获取币种详情
	 */
	public function getProinfo() {
		$ProDomain = new ProDomain();
        $profile = $ProDomain->getProInfo($this->pid, '*');
        $this->profile = $profile ? $profile : $this->profile;
        return $profile;
	}

	/**
	 * 所有币种信息接口
	 * @desc 获取所有币种信息
	 */
	public function getProsinfo() {
		$ProDomain = new ProDomain();
        $profile = $ProDomain->getAllInfo();
        $this->profile = $profile ? $profile : $this->profile;
        return array($profile);
	}
}