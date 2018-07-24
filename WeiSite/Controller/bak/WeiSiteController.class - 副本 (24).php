<?php

namespace Addons\WeiSite\Controller;

use Addons\WeiSite\Controller\BaseController;

class WeiSiteController extends BaseController {
	function config() {
		// 使用提示
		$publicid = get_token_appinfo('','id');
		$normal_tips = '在微信里回复“微官网”即可以查看效果，也可点击:<a target="_blank" href="' . U ( 'preview' ) . '">预览</a>,<a id="copyLink" data-clipboard-text="' . U ( 'index',array('publicid'=>$publicid)) . '">复制链接</a><script type="application/javascript">$.WeiPHP.initCopyBtn("copyLink");</script>';
		$this->assign ( 'normal_tips', $normal_tips );

		if (IS_POST) {
			$flag = D ( 'Common/AddonConfig' )->set ( _ADDONS, $_POST ['config'] );

			if ($flag !== false) {
				$this->success ( '保存成功', Cookie ( '__forward__' ) );
			} else {
				$this->error ( '保存失败' );
			}
			exit ();
		}

		parent::config ();
	}
	//购物指南-预定须知
	function BookingNotesXz(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$id=I ( 'get.id', 0, 'intval' )?I ( 'get.id', 0, 'intval' ):12;
		$this->assign ( 'loandid', $id );
		$this->assign ( 'loandcss', 'BookingNotesXz' );

		//获取分类
		$mapfl['pid']=11;
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->select ();
		$this->assign('infofl',$infofl);

		$map ['cate_id'] = $id;//I ( 'get.id', 0, 'intval' );
		$info = M ( 'custom_reply_news' )->where ( $map )->find ();

		//获取分类顶部图片
		$mapimg['id']=$id;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		$this->assign('xltitle',$infoimg['title'].'-艾娜西点');
		$this->assign('keyword',$infoimg['title'].',艾娜西点');
		$this->assign('intro',$infoimg['title'].'-艾娜西点');



		$this->assign ( 'info', $info );

		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/BookingNotesXz.html' );
	}
	//最新推荐
	function LatestRecomm(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'LatestRecomm' );
		
		$mapall['cate_id']=15;
						//下架显示隐藏
						$mapall['xiajss']=array('NEQ',2);
		
		$s = M ( 'custom_reply_news' )->where ( $mapall )->order ( 'sort asc, id DESC' )->select ();
		
		//获取分类顶部图片
		$mapimg['id']=15;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$infoimg = get_cover_url ( $infoimg ['icon'] );
		
		$mapimg['id']=14;
		$infoimgss = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$nnurlss=$infoimgss ['url'];
		$this->assign ( 'nnurlss', $nnurlss );
		
		
		
		$this->assign('xltitle','新品推荐-艾娜西点');
		$this->assign('keyword','新品推荐,艾娜西点');
		$this->assign('intro','新品推荐-艾娜西点');
		$this->assign ( 'infoimg', $infoimg );
		
		$this->assign ( 's', $s );
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/LatestRecomm.html' );
	}

	
	
	
	//产品名录
	function Products(){
		
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$id=I ( 'get.id', 0, 'intval' )?I ( 'get.id', 0, 'intval' ):6;
		$this->assign ( 'loandid', $id );
		$this->assign ( 'loandcss', 'Products' );

		//获取分类
		$mapfl['pid']=6;
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->order('sort asc ,id desc')->select ();
		$this->assign('infofl',$infofl);
		//dump($infofl);

		//echo $nnnid;

		//获取分类顶部图片
		$mapimg['id']=$id;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		$this->assign('xltitle',$infoimg['title'].'-艾娜西点');
		$this->assign('keyword',$infoimg['title'].',艾娜西点');
		$this->assign('intro',$infoimg['title'].'-艾娜西点');
		$this->assign ( 'info', $info );

		$nnpn=($this->config);
		$nnpn=$nnpn['cooajaxss'];
		if($id==6){
		//获取所有产品
		foreach ($infofl as $k => $v) {
			if(!$nnnid) $nnnid=$v['id'];
			else $nnnid.=','.$v['id'];
		}

		$mapall['cate_id']=array('in','6,'.$nnnid);
		//下架显示隐藏
		$mapall['xiajss']=array('NEQ',2);
		
		$this->assign ( 'moooid', 'a6,'.$nnnid);
		$list_data = M ( 'custom_reply_news' )->where ( $mapall )->order ( 'sort asc, id DESC' )->limit ( 0, $nnpn )->select ();
		//$this->lists("array('in','6,7,8')",0,$nnpn);
		}
		else{
			$this->assign ( 'moooid', $id );
			$list_data=$this->lists($id,0,$nnpn);
			$list_data=$list_data['list_data'];
		}
		$this->assign ( 'list_data_new', $list_data );
		//dump($list_data);

		$this->_footer ();
		//$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		//dump($infoimg);

		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/Products.html' );
	}
	//产品名录-Ajax
	function ProductsAjax(){
		$nnpn=($this->config);
		$nnpn=$nnpn['cooajaxss'];
		$pn=I ( 'get.ajaxid', 0, 'intval' );
		$moooid=I ( 'get.moidd')+0;
		if(!$moooid){
			//所有产品

				//下架显示隐藏
				$mapall['xiajss']=array('NEQ',2);
				$mapall['cate_id']=array('in',substr(I ( 'get.moidd'),1));
				$list_data = M ( 'custom_reply_news' )->where ( $mapall )->order ( 'sort asc, id DESC' )->limit ( ($pn*$nnpn), $nnpn )->select ();

		}
		else{
			$list_data=$this->lists($moooid,$pn,$nnpn);
			$list_data=$list_data['list_data'];
		}



		$ccc=count($list_data);
		if($ccc<1) {
			echo '';
			return false;
		}
		$this->assign ( 'list_data_new', $list_data );
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/ProductsAjax.html' );
	}
	//商品详情
	function blnxiangqing(){
		if(!$_COOKIE['tel'] || !$_COOKIE['logg']) $no_login=1;
		$this->assign ( 'no_login', $no_login );
		
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$this->assign ( 'fuqshifoufanwang', $_SESSION['dangqian_url']);
		
		//微信支付失败返回链接
		$_SESSION['dangqian_url_weixinzhifushibai']=__SELF__;
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$map ['id'] = I ( 'get.id', 0, 'intval' );
		$info = M ( 'custom_reply_news' )->where ( $map )->find ();
		//dump($info);exit;
		//删除到期未付款购物车抢购商品
		if($info['qianggou']==1){
					//$cjzssddggzzggmmqqgg=($this->config);
					//$cjzssddggzzggmmqqgg=$cjzssddggzzggmmqqgg['cjzssddggzzggmmqqgg']+0;
			$ddtmmmmm['sid']=$map ['id'];
			$ddtmmmmm['qtime']=array('lt',(time()-30));
			$ddtmmmmm['ok']=0;
			//$ddddookkkSSSS=M('dingdantem')->where($ddtmmmmm)->select();
			
			$ddddookkk=M('dingdantem')->where($ddtmmmmm)->delete();
			//dump($ddddookkk);exit;
			$ddddddsssup['id']=$map ['id'];
			$uppsssdddsata['qgnum']=array('exp','qgnum+'.$ddddookkk);
			$uppsssdddsata['cpnum'] = array('exp','cpnum+'.$ddddookkk);
			$ddssokkuuppidsss=M('custom_reply_news')->where($ddddddsssup)->save($uppsssdddsata);
			//$_SESSION['ddddookkk']=1;//count($ddddookkkSSSS);
		}
		
		
		$this->assign('xltitle',$info['title'].'-艾娜西点');
		$this->assign('keyword',$info['keyword'].',艾娜西点');
		$this->assign('intro',$info['intro'].'-艾娜西点');
		
		$this->assign ( 'info', $info );
		
		$this->assign ( 'loandcss', 'blnxiangqing' );
		//echo ONETHINK_ADDON_PATH;
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/blnxiangqing.html' );
	}
	//品牌故事
	function BrandStory(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'BrandStory' );
		$this->assign('xltitle','品牌故事-艾娜西点');


		$map ['cate_id'] = 2;//I ( 'get.id', 0, 'intval' );
		$info = M ( 'custom_reply_news' )->where ( $map )->find ();
		//获取分类顶部图片
		$mapimg['id']=2;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		$this->assign('keyword',$info ['keyword']);
		$this->assign('intro',$info ['intro']);
		$this->assign ( 'info', $info );
		M ( 'custom_reply_news' )->where ( $map )->setInc ( 'view_count' );

		
		//获取分类
		$mapfl['pid']=1;
		$this->assign ( 'loandid', 2 );
		$nnnsssurl=array(3=>'/index.php?s=/addon/WeiSite/WeiSite/BakingRoom.html',5=>'/index.php?s=/addon/WeiSite/WeiSite/ContactUs.html',4=>'/index.php?s=/addon/WeiSite/WeiSite/Cooperation.html',2=>'/index.php?s=/addon/WeiSite/WeiSite/BrandStory.html');
		$this->assign('nnnsssurl',$nnnsssurl);
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->order('sort asc ,id desc')->select ();
		$this->assign('infofl',$infofl);
		
		
		$this->_footer ();
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/BrandStory.html' );
	}
	//活动动态
	function DynamicActivity(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'DynamicActivity' );
		$this->assign('xltitle','活动动态-艾娜西点');
		$this->assign('keyword','活动动态,艾娜西点');
		$this->assign('intro','活动动态-艾娜西点');
		//$nnpn=($this->config);
		$nnpn=999999;//$nnpn['cooajax'];
		//获取分类顶部图片
		$mapimg['id']=14;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );

		$nnurlss=$infoimg ['url'];
		$this->assign ( 'nnurlss', $nnurlss );
		
		$this->assign ( 'info', $info );
		$list_data=$this->lists(14,0,$nnpn);
		$this->assign ( 'list_data_new', $list_data );
		//dump($list_data);
		$this->_footer ();
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/DynamicActivity.html' );
	}
	
	
	//企业合作
	function Cooperation(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'Cooperation' );
		$this->assign('xltitle','企业合作-艾娜西点');
		$this->assign('keyword','企业合作,艾娜西点');
		$this->assign('intro','企业合作-艾娜西点');
		$nnpn=($this->config);
		$nnpn=$nnpn['cooajax'];
		//获取分类顶部图片
		$mapimg['id']=4;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );

		//获取分类
		$mapfl['pid']=1;
		$this->assign ( 'loandid', 4 );
		$nnnsssurl=array(3=>'/index.php?s=/addon/WeiSite/WeiSite/BakingRoom.html',5=>'/index.php?s=/addon/WeiSite/WeiSite/ContactUs.html',4=>'/index.php?s=/addon/WeiSite/WeiSite/Cooperation.html',2=>'/index.php?s=/addon/WeiSite/WeiSite/BrandStory.html');
		$this->assign('nnnsssurl',$nnnsssurl);
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->order('sort asc ,id desc')->select ();
		$this->assign('infofl',$infofl);
		
		
		$this->assign ( 'info', $info );
		$list_data=$this->lists(4,0,$nnpn);
		$this->assign ( 'list_data_new', $list_data );
		//dump($list_data);
		$this->_footer ();
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/Cooperation.html' );
	}
	//企业合作-Ajax
	function CooperationAjax(){
		$nnpn=($this->config);
		$nnpn=$nnpn['cooajax'];
		$list_data=$this->lists(4,I ( 'get.ajaxid', 0, 'intval' ),$nnpn);
		$ccc=count($list_data['list_data']);
		if($ccc<1) {
			echo '';
			return false;
		}
		$this->assign ( 'list_data_new', $list_data );
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/CooperationAjax.html' );
	}
	//活动详情
	function DynamicActivityDetail(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$info=$this->detail(I ( 'get.id', 0, 'intval' ));
		$this->assign ( 'loandcss', 'Cooperation' );
		$this->assign('xltitle',$info['title']);
		$this->assign('keyword',$info['keyword']);
		$this->assign('intro',$info['intro']);
		//获取分类顶部图片
		$mapimg['id']=14;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		$this->assign('info',$info);
		

		$nnurlss=$infoimg ['url'];
		$this->assign ( 'nnurlss', $nnurlss );
		
		//$this->assign('infoss',);
		//dump($info);
		$this->_footer ();
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/DynamicActivityDetail.html' );
	}
	//在线客服
	function OnlineService(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'OnlineService' );
		$this->assign('xltitle','在线客服-艾娜西点');
		$this->assign('keyword','在线客服,艾娜西点');
		$this->assign('intro','在线客服-艾娜西点');
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/OnlineService.html' );
	}
	//建议留言
	function message(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		if($_POST){
			$da['xingm']=I ( 'xingm', 0, 'strip_tags' );
			$da['tel']=I ( 'tel', 0, 'strip_tags' );
			$da['content']=I ( 'content', 0, 'strip_tags' );
			$da['ctime']=time();
			//dump($da);
			if(!$da['content']) exit;
			$result = M('newmessage')->add($da);
			if($result) {
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/message.html');exit;
			}
		}
		
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'message' );
		$this->assign('xltitle','建议留言-艾娜西点');
		$this->assign('keyword','建议留言,艾娜西点');
		$this->assign('intro','建议留言-艾娜西点');
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/message.html' );
		
	}
	
	//企业合作-详情
	function CooperationDetail(){
		$info=$this->detail(I ( 'get.id', 0, 'intval' ));
		$this->assign ( 'loandcss', 'Cooperation' );
		$this->assign('xltitle',$info['title']);
		$this->assign('keyword',$info['keyword']);
		$this->assign('intro',$info['intro']);
		//获取分类顶部图片
		$mapimg['id']=4;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		$this->assign('info',$info);
		//$this->assign('infoss',);
		//dump($info);
		$this->_footer ();
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/CooperationDetail.html' );
	}
	//关于艾娜-烘焙教程
	function BakingRoom(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'BakingRoom' );
		$this->assign('xltitle','烘焙教程-艾娜西点');

		$map ['cate_id'] = 3;//I ( 'get.id', 0, 'intval' );
		$info = M ( 'custom_reply_news' )->where ( $map )->find ();

		//获取分类顶部图片
		$mapimg['id']=3;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );
		
		//获取分类
		$mapfl['pid']=1;
		$this->assign ( 'loandid', 3 );
		$nnnsssurl=array(3=>'/index.php?s=/addon/WeiSite/WeiSite/BakingRoom.html',5=>'/index.php?s=/addon/WeiSite/WeiSite/ContactUs.html',4=>'/index.php?s=/addon/WeiSite/WeiSite/Cooperation.html',2=>'/index.php?s=/addon/WeiSite/WeiSite/BrandStory.html');
		$this->assign('nnnsssurl',$nnnsssurl);
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->order('sort asc ,id desc')->select ();
		$this->assign('infofl',$infofl);
		
		
		
		//dump($info);
		$this->assign ( 'info', $info );
		M ( 'custom_reply_news' )->where ( $map )->setInc ( 'view_count' );
		$this->assign('keyword',$info ['keyword']);
		$this->assign('intro',$info ['intro']);
		$this->_footer ();
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/BakingRoom.html' );
	}
	//关于艾娜-联系我们
	function ContactUs(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$this->assign ( 'loandcss', 'ContactUs' );
		$this->assign('xltitle','联系我们-艾娜西点');
		$this->assign('keyword','联系我们-艾娜西点');
		$this->assign('intro','联系我们-艾娜西点');
		//获取分类顶部图片
		$mapimg['id']=5;
		$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		$info ['img'] = get_cover_url ( $infoimg ['icon'] );

		//获取分类
		$mapfl['pid']=1;
		$this->assign ( 'loandid', 5 );
		$nnnsssurl=array(3=>'/index.php?s=/addon/WeiSite/WeiSite/BakingRoom.html',5=>'/index.php?s=/addon/WeiSite/WeiSite/ContactUs.html',4=>'/index.php?s=/addon/WeiSite/WeiSite/Cooperation.html',2=>'/index.php?s=/addon/WeiSite/WeiSite/BrandStory.html');
		$this->assign('nnnsssurl',$nnnsssurl);
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->order('sort asc ,id desc')->select ();
		$this->assign('infofl',$infofl);

		
		
		$this->assign ( 'info', $info );
		$this->_footer ();
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/ContactUs.html' );
	}

	//购物指南-区域说明
	function BookingNotesSm(){
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/BookingNotesSm.html' );
	}
	
	//随机盐--大写
	function generate_rand_zmdx($l){
	  $c= "ABCDEFGHJKLMNPQRSTUVWXY";
	  srand((double)microtime()*1000000);
	  for($i=0; $i<$l; $i++) {
		  $rand.= $c[rand()%strlen($c)];
	  }
	  return $rand;
	}
	
	
	//抽奖
	
				function getRand($proArr) {
					$data = '';
					$proSum = array_sum($proArr); //概率数组的总概率精度 

					foreach ($proArr as $k => $v) { //概率数组循环
						$randNum = mt_rand(1, $proSum);
						if ($randNum <= $v) {
							$data = $k;
							break;
						} else {
							$proSum -= $v;
						}
					}
					unset($proArr);

					return $data;
				}
function newtestss() {
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		add_credit ( 'weisite', 86400 );
		
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );

		//过期
		$tongzhiggnryxqccjjj=($this->config);
		$tongzhiggnryxqccjjj=$tongzhiggnryxqccjjj['tongzhiggnryxqccjjj'];
		$this->assign ( 'tongzhiggnryxqccjjj', $tongzhiggnryxqccjjj );
		$tongzhiggnryxqccjjj=strtotime($tongzhiggnryxqccjjj);
		if(time()>$tongzhiggnryxqccjjj) $this->choujiangguoqi();
		

			$tongzhigonggao=($this->config);
			$tongzhiggnr=$tongzhigonggao['tongzhiggnr'];
			$this->assign ( 'tongzhiggnr', $tongzhiggnr );
			$this->assign ( 'tongzhiggnryxxms', $tongzhigonggao['tongzhiggnryxxms']*1000 );
			$this->assign ( 'tongzhiggnryxq', $tongzhigonggao['tongzhiggnryxq'] );
			
		$tongzhiggnryxxmsccdd=$tongzhigonggao['tongzhiggnryxxmsccdd'];
		
		$tongzhiggnryxqno=0;
		if(time()<strtotime($tongzhigonggao['tongzhiggnryxq']) && $tongzhiggnryxxmsccdd){
			$tongzhiggnryxqno=1;
		}
			$this->assign ( 'tongzhiggnryxqno', $tongzhiggnryxqno );
		
		
		
		
		
		
		
		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_index'] . '.html' )) {
			$this->pigcms_index ();
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_index'] . '.html' );
		} else {
			//$map ['token'] = get_token ();
			$map ['is_show'] = 1;
			$map ['pid'] = 0; // 获取一级分类

			// 幻灯片
			$slideshow = M ( 'weisite_slideshow' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
			foreach ( $slideshow as &$vo ) {
				$vo ['img'] = get_cover_url ( $vo ['img'] );
			}
			$this->assign ( 'slideshow', $slideshow );
			//dump($slideshow);

			//新品推荐
						//下架显示隐藏
						$mapc['xiajss']=array('NEQ',2);
			$nnpn=($this->config);
			$nnpn=$nnpn['xinpp'];
			$mapc['cate_id']=15;
			$s_tel=M('custom_reply_news')->where($mapc)->order ( 'sort asc, id desc' )->limit(0,$nnpn)->select();
			$this->assign ( 'tj', $s_tel );
			
			//dump($s_tel);
			// 分类
			$category = M ( 'weisite_category' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
			foreach ( $category as &$vo ) {
				$vo ['icon'] = get_cover_url ( $vo ['icon'] );
				empty ( $vo ['url'] ) && $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', array (
						'cate_id' => $vo ['id']
				) );
			}
			$this->assign ( 'category', $category );

			$map2 ['token'] = $map ['token'];
			$public_info = get_token_appinfo ( $map2 ['token'] );
			$this->assign ( 'publicid', $public_info ['id'] );

			$this->assign ( 'manager_id', $this->mid );


			$this->assign ( 'loandcss', 'index' );
			$this->assign('xltitle','首页-艾娜西点');


			$this->_footer ();

			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/newtestss.html' );
		}
	}
	//关注公众号后送抽奖机会
	function test(){
		
		//过期
		$tongzhiggnryxqccjjj=($this->config);
		$tongzhiggnryxqccjjj=$tongzhiggnryxqccjjj['tongzhiggnryxqccjjj'];
		$this->assign ( 'tongzhiggnryxqccjjj', $tongzhiggnryxqccjjj );
		$tongzhiggnryxqccjjj=strtotime($tongzhiggnryxqccjjj);
		if(time()>$tongzhiggnryxqccjjj) $this->choujiangguoqi();
		
		//echo get_openid();
		setcookie("tel", 0, time()-3600000);
		setcookie("logg", 0, time()-3600000);
		$_SESSION['guanzhu_choujiang_tel']=0;
		$_SESSION['guanzhu_choujiang_uid']=0;
		$_SESSION['guanzhu_choujiang_one']=0;
		$_SESSION['guanzhu_choujiang_two']=0;
			$nnpncjzssddcjzssddggzz=($this->config);
			$nnpncjzssddcjzssddggzz=$nnpncjzssddcjzssddggzz['cjzssddggzz']+0;
		if(get_openid()) $_SESSION['guanzhu_choujiang']=$nnpncjzssddcjzssddggzz;//2;
		header('Location:/index.php?s=/addon/WeiSite/WeiSite/LuckDrawnew.html');exit;
		//dump($_SESSION['guanzhu_choujiang']);
		//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/test.html' );
	}
	
	//录音
	function luyin(){
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/luyin.html' );
	}
	
	//测试
	function ceshi(){
		
			$tongzhigonggao=($this->config);
			$tongzhiggnr=$tongzhigonggao['tongzhiggnr'];
			$this->assign ( 'tongzhiggnr', $tongzhiggnr );
			$this->assign ( 'tongzhiggnryxxms', $tongzhigonggao['tongzhiggnryxxms']*1000 );
			$this->assign ( 'tongzhiggnryxq', $tongzhigonggao['tongzhiggnryxq'] );
			
		$tongzhiggnryxxmsccdd=$tongzhigonggao['tongzhiggnryxxmsccdd'];
		
		$tongzhiggnryxqno=0;
		if(time()<strtotime($tongzhigonggao['tongzhiggnryxq']) && $tongzhiggnryxxmsccdd){
			$tongzhiggnryxqno=1;
		}
			$this->assign ( 'tongzhiggnryxqno', $tongzhiggnryxqno );
		
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/ceshi.html' );
	}
	function LuckDrawnew(){
		
		//dump($_SESSION);exit;
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/LuckDraw.html';
		//获取会员抽奖信息资格
		$codeddd=I ( 'codeddd');
		if($codeddd=='ok'){
			
			//$user=$this->jjccddll_noj();
			//dump($user);exit;
			if(!$_SESSION['guanzhu_choujiang']){
				$datac['cjzs']='nologin';
				echo json_encode($datac);
				exit;
			}
		}
		if(!$_SESSION['guanzhu_choujiang']) {
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/zxcjj.html');exit;
		}
		$id=I ( 'get.id', 0, 'intval' );//注意id判断ajax转入id伪造
		if($id) $mapc['id']=$id;
		$mapc['cjend']=array('gt',time());
		$s_tel=M('hcjhd')->where($mapc)->order('id desc')->limit(0,1)->select();
			//抽奖开始时间、结束时间 符合法访问
			if(($s_tel['0']['cjbegin']>(time()+30)) || ($s_tel['0']['cjend']<(time()-30))){
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/zxcjj/index.html');exit;
			}
			//当前抽奖id
			$id=$s_tel['0']['id'];
			//$dataqc['id']=$s_tel;
		$s_tel=$s_tel['0'];
		//dump($s_tel['ttielll']);exit;
		$cjccsss=$_SESSION['guanzhu_choujiang'];//3;//抽奖次数
		$this->assign ( 'cjccsss', $cjccsss );
		$this->assign ( 'cjccsssid', $id );
			
			/*算法*/
				//prize表示奖项内容，v表示中奖几率(若数组中七个奖项的v的总和为100，如果v的值为1，则代表中奖几率为1%，依此类推)
				if($codeddd=='ok'){
					if($_SESSION['guanzhu_choujiang']<1) {
						$datac['cjzs']='no';
						echo json_encode($datac);
						exit;
					}
					//更新会员抽奖次数
					$_SESSION['guanzhu_choujiang']=$_SESSION['guanzhu_choujiang']-1;
					

					
					$prize_arr = array(
						'0' => array('id' => 1,  'goumai' => $s_tel['oneshiwu'],'pic' => $s_tel['onepic'],'text' => $s_tel['onetext'], 'name'=>'one','num'=>$s_tel['onenum'],'centen'=>$s_tel['onecenten'],'type'=>$s_tel['onetype'],'v' => $s_tel['onegailv']*1000000),
						'1' => array('id' => 2,  'goumai' => $s_tel['twoshiwu'],'pic' => $s_tel['twopic'],'text' => $s_tel['twotext'], 'name'=>'two','num'=>$s_tel['twonum'],'centen'=>$s_tel['twocenten'],'type'=>$s_tel['twotype'],'v' => $s_tel['twogailv']*1000000),
						'2' => array('id' => 3,  'goumai' => $s_tel['freshiwu'],'pic' => $s_tel['frepic'],'text' => $s_tel['fretext'], 'name'=>'fre','num'=>$s_tel['frenum'],'centen'=>$s_tel['frecenten'],'type'=>$s_tel['fretype'],'v' => $s_tel['fregailv']*1000000),
						'3' => array('id' => 4,  'goumai' => $s_tel['foushiwu'],'pic' => $s_tel['foupic'],'text' => $s_tel['foutext'], 'name'=>'fou','num'=>$s_tel['founum'],'centen'=>$s_tel['foucenten'],'type'=>$s_tel['foutype'],'v' => $s_tel['fougailv']*1000000),
						'4' => array('id' => 5,  'goumai' => $s_tel['fivshiwu'],'pic' => $s_tel['fivpic'],'text' => $s_tel['fivtext'], 'name'=>'fiv','num'=>$s_tel['fivnum'],'centen'=>$s_tel['fivcenten'],'type'=>$s_tel['fivtype'],'v' => $s_tel['fivgailv']*1000000),
						'5' => array('id' => 6,  'goumai' => $s_tel['sixshiwu'],'pic' => $s_tel['sixpic'],'text' => $s_tel['sixtext'], 'name'=>'six','num'=>$s_tel['sixnum'],'centen'=>$s_tel['sixcenten'],'type'=>$s_tel['sixtype'],'v' => $s_tel['sixgailv']*1000000),
						'6' => array('id' => 7,  'goumai' => $s_tel['sveshiwu'],'pic' => $s_tel['svepic'],'text' => $s_tel['svetext'], 'name'=>'sve','num'=>$s_tel['svenum'],'centen'=>$s_tel['svecenten'],'type'=>$s_tel['svetype'],'v' => $s_tel['svegailv']*1000000),
						'7' => array('id' => 8,  'goumai' => $s_tel['egishiwu'],'pic' => $s_tel['egipic'],'text' => $s_tel['egitext'], 'name'=>'egi','num'=>$s_tel['eginum'],'centen'=>$s_tel['egicenten'],'type'=>$s_tel['egitype'],'v' => $s_tel['egigailv']*1000000),
					);
					//dump($prize_arr);
					foreach ($prize_arr as $k=>$v) {
						if($v['num']) $arr[$v['id']] = $v['v'];

					}

					$prize_id = $this->getRand($arr); //根据概率获取奖项id
					foreach($prize_arr as $k=>$v){ //获取前端奖项位置
						if($v['id'] == $prize_id){
						 $prize_site = $k;
						 break;
						}
					}
					$res = $prize_arr[$prize_id - 1]; //中奖项 
					$res['ttielll']=$s_tel['ttielll'];
					if(!$_SESSION['guanzhu_choujiang_one']) $_SESSION['guanzhu_choujiang_one']=$res;
					else{
						$_SESSION['guanzhu_choujiang_two']=$res;
					}
					
					$datac['prize_name'] = $res['text'];
					$datac['type']=$res['type'];
					$datac['centen']=$res['centen'];
					$datac['prize_site'] = $prize_site;//前端奖项从-1开始
					$datac['prize_id'] = $prize_id;
					
					//写入抽奖记录 
					$cjjlldata['ctime']=time();
					$cjjlldata['duij']=0;
					//红包优惠券自动兑奖
					if($res['type']==2) {
						$cjjlldata['duij']=1;
						//添加会员优惠券
						$hyqqdata['uid']=$user['id'];
						$hyqqdata['jine']=$res['centen'];
						
						$nnpn=($this->config);
						$nnpn=$nnpn['zssdjjedyxq']*86400;
						$nnpn=$nnpn+time();
						$hyqqdata['etime']=$nnpn;
						
						$nnpn=($this->config);
						$nnpn=$nnpn['gwdjqq'];
						$hyqqdata['xe']=$nnpn;
						//$hyqadd=M('huiyouhuiq')->add($hyqqdata);
						
						
					}
					//但不是3谢谢惠顾模式
					if($res['type']==1) $cjjlldata['duim']=date('Ymd').$user['id'].$this->generate_rand_zmdx(10);//.$this->getip().$res['type'];
					//奖品减少
					if($res['type']!=3){
						
						$name=$res['name'];
						$jsw['id']=$id;
						$jsdata[$name.'num']=($res['num']-1)+0;
						//$jsm=M('hcjhd')->where($jsw)->save($jsdata);
					}
					//dump($res);
					$cjjlldata['pic']=$res['pic'];
					$cjjlldata['uid']=$user['id'];
					$cjjlldata['goumai']=$res['goumai'];
					$cjjlldata['tel']=$user['tel'];
					$cjjlldata['info']=$res['text'];
					$cjjlldata['centen']=$res['centen'];
					$cjjlldata['type']=$res['type'];
					$cjjlldata['cjtitle']=$s_tel['ttielll'];//抽奖活动标题
					//$rscjjll=M('cjjll')->add($cjjlldata);
					
					
					
					echo json_encode($datac);
					exit;
				}

			/*end*/
		
		
		
		
		
		$this->assign ( 's', $s_tel );
		//dump($s_tel);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/LuckDrawnew.html' );
	}
	
	//会员注册写入抽奖信息
	function ssxxeccjjjxx(){
			//sleep(1);
			//$user=$this->jjccddll();
			//echo $user['id'];
			//$w['uid']=55;//$user['id'];
			//$hyqadd=M('cjjll')->where($w)->delete();exit;
		/*	
		dump($_SESSION['guanzhu_choujiang']);
		dump($_SESSION['guanzhu_choujiang_one']);
		dump($_SESSION['guanzhu_choujiang_two']);
		exit;
		*/
			
		
		
			if($_SESSION['guanzhu_choujiang_one']){
				//$_SESSION['guanzhu_choujiang_one']['uid']=$user['id'];
				//$_SESSION['guanzhu_choujiang_one']['tel']=$user['tel'];
				$res=$_SESSION['guanzhu_choujiang_one'];
				$_SESSION['guanzhu_choujiang_one']=0;
			}
			else if($_SESSION['guanzhu_choujiang_two']){
				//$_SESSION['guanzhu_choujiang_two']['uid']=$user['id'];
				//$_SESSION['guanzhu_choujiang_two']['tel']=$user['tel'];
				$res=$_SESSION['guanzhu_choujiang_two'];
				$_SESSION['guanzhu_choujiang_two']=0;
			}
			else return false;
			
			//$res = $prize_arr[$prize_id - 1]; //中奖项 
			$datac['prize_name'] = $res['text'];
			$datac['type']=$res['type'];
			$datac['centen']=$res['centen'];
			$datac['prize_site'] = $prize_site;//前端奖项从-1开始
			$datac['prize_id'] = $prize_id;
			
			//写入抽奖记录 
			$cjjlldata['ctime']=time();
			$cjjlldata['duij']=0;
			//红包优惠券自动兑奖
			if($res['type']==2) {
				$cjjlldata['duij']=1;
				//添加会员优惠券
				$hyqqdata['uid']=$_SESSION['guanzhu_choujiang_uid'];//$user['id'];
				$hyqqdata['jine']=$res['centen'];
				
				$nnpn=($this->config);
				$nnpn=$nnpn['zssdjjedyxq']*86400;
				$nnpn=$nnpn+time();
				$hyqqdata['etime']=$nnpn;
				
				$nnpn=($this->config);
				$nnpn=$nnpn['gwdjqq'];
				$hyqqdata['xe']=$nnpn;
				$hyqadd=M('huiyouhuiq')->add($hyqqdata);
				
				
			}
			//但不是3谢谢惠顾模式
			if($res['type']==1) $cjjlldata['duim']=date('Ymd').$_SESSION['guanzhu_choujiang_uid'].$this->generate_rand_zmdx(10);//.$this->getip().$res['type'];
			//奖品减少
			if($res['type']!=3){
				
				$name=$res['name'];
				$jsw['id']=$res['id'];
				$jsdata[$name.'num']=($res['num']-1)+0;
				$jsm=M('hcjhd')->where($jsw)->save($jsdata);
			}
			//dump($res);
			$cjjlldata['pic']=$res['pic'];
			$cjjlldata['uid']=$_SESSION['guanzhu_choujiang_uid'];
			$cjjlldata['tel']=$_SESSION['guanzhu_choujiang_tel'];
			$cjjlldata['info']=$res['text'];
			$cjjlldata['goumai']=$res['goumai'];
			$cjjlldata['centen']=$res['centen'];
			$cjjlldata['type']=$res['type'];
			$cjjlldata['cjtitle']=$res['ttielll'];//抽奖活动标题
			$rscjjll=M('cjjll')->add($cjjlldata);
		
			if($_SESSION['guanzhu_choujiang_two']) $this->ssxxeccjjjxx();
			
			//dump($_SESSION['guanzhu_choujiang_one']);
			//exit;
			
			
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//会员抽奖		
	function LuckDraw(){
		
		//过期
		$tongzhiggnryxqccjjj=($this->config);
		$tongzhiggnryxqccjjj=$tongzhiggnryxqccjjj['tongzhiggnryxqccjjj'];
		$this->assign ( 'tongzhiggnryxqccjjj', $tongzhiggnryxqccjjj );
		$tongzhiggnryxqccjjj=strtotime($tongzhiggnryxqccjjj);
		if(time()>$tongzhiggnryxqccjjj) $this->choujiangguoqi();
		
		
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/LuckDraw.html';
		//获取会员抽奖信息资格
		$codeddd=I ( 'codeddd');
		if($codeddd=='ok'){
			
			$user=$this->jjccddll_noj();
			//dump($user);exit;
			if(!$user){
				$datac['cjzs']='nologin';
				echo json_encode($datac);
				exit;
			}
		}
		
		
		$user=$this->jjccddll();
		//dump($user);
		
		
		$hhcjdata['id']=$user['id'];
		$hhccjj=M('huiyuan')->where($hhcjdata)->limit(0,1)->select();
					
		//获取今天的时间
		$n_data=date('Ymd');
		//会员今天登录时间
		$h_data=$hhccjj['0']['dtime'];
		//会员今天是否已经抽奖 dcjsf
		$h_dcjsf=$hhccjj['0']['dcjsf'];
		//echo $h_dcjsf;exit;
		//会员剩余抽奖次数
		$h_zcj=$hhccjj['0']['zcj']+$hhccjj['0']['dcjsf'];
		
		//echo $h_zcj;exit;
		
		
		
		
		$id=I ( 'get.id', 0, 'intval' );//注意id判断ajax转入id伪造
		if($id) $mapc['id']=$id;
		$mapc['cjend']=array('gt',time());
		$s_tel=M('hcjhd')->where($mapc)->order('id desc')->limit(0,1)->select();
			//抽奖开始时间、结束时间 符合法访问
			if(($s_tel['0']['cjbegin']>(time()+30)) || ($s_tel['0']['cjend']<(time()-30))){
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/zxcjj/index.html');exit;
			}
			//当前抽奖id
			$id=$s_tel['0']['id'];
			//$dataqc['id']=$s_tel;
		$s_tel=$s_tel['0'];
		$cjccsss=$h_zcj;//3;//抽奖次数
		$this->assign ( 'cjccsss', $cjccsss );
		$this->assign ( 'cjccsssid', $id );
			
			/*算法*/
				//prize表示奖项内容，v表示中奖几率(若数组中七个奖项的v的总和为100，如果v的值为1，则代表中奖几率为1%，依此类推)
				if($codeddd=='ok'){
					if($h_zcj<1) {
						$datac['cjzs']='no';
						echo json_encode($datac);
						exit;
					}
					//更新会员抽奖次数
					if(($h_data==$n_data) && $h_dcjsf){//使用会员登录抽奖次数
						$data['dcjsf']=0;
					}
					if(!$h_dcjsf){
						$data['zcj']=$hhccjj['0']['zcj']-1;
					}
					
					$upwcjh['id']=$user['id'];
					$hhccjjup=M('huiyuan')->where($upwcjh)->save($data);
					
					$prize_arr = array(
						'0' => array('id' => 1,  'goumai' => $s_tel['oneshiwu'],'pic' => $s_tel['onepic'],'text' => $s_tel['onetext'], 'name'=>'one','num'=>$s_tel['onenum'],'centen'=>$s_tel['onecenten'],'type'=>$s_tel['onetype'],'v' => $s_tel['onegailv']*1000000),
						'1' => array('id' => 2,  'goumai' => $s_tel['twoshiwu'],'pic' => $s_tel['twopic'],'text' => $s_tel['twotext'], 'name'=>'two','num'=>$s_tel['twonum'],'centen'=>$s_tel['twocenten'],'type'=>$s_tel['twotype'],'v' => $s_tel['twogailv']*1000000),
						'2' => array('id' => 3,  'goumai' => $s_tel['freshiwu'],'pic' => $s_tel['frepic'],'text' => $s_tel['fretext'], 'name'=>'fre','num'=>$s_tel['frenum'],'centen'=>$s_tel['frecenten'],'type'=>$s_tel['fretype'],'v' => $s_tel['fregailv']*1000000),
						'3' => array('id' => 4,  'goumai' => $s_tel['foushiwu'],'pic' => $s_tel['foupic'],'text' => $s_tel['foutext'], 'name'=>'fou','num'=>$s_tel['founum'],'centen'=>$s_tel['foucenten'],'type'=>$s_tel['foutype'],'v' => $s_tel['fougailv']*1000000),
						'4' => array('id' => 5,  'goumai' => $s_tel['fivshiwu'],'pic' => $s_tel['fivpic'],'text' => $s_tel['fivtext'], 'name'=>'fiv','num'=>$s_tel['fivnum'],'centen'=>$s_tel['fivcenten'],'type'=>$s_tel['fivtype'],'v' => $s_tel['fivgailv']*1000000),
						'5' => array('id' => 6,  'goumai' => $s_tel['sixshiwu'],'pic' => $s_tel['sixpic'],'text' => $s_tel['sixtext'], 'name'=>'six','num'=>$s_tel['sixnum'],'centen'=>$s_tel['sixcenten'],'type'=>$s_tel['sixtype'],'v' => $s_tel['sixgailv']*1000000),
						'6' => array('id' => 7,  'goumai' => $s_tel['sveshiwu'],'pic' => $s_tel['svepic'],'text' => $s_tel['svetext'], 'name'=>'sve','num'=>$s_tel['svenum'],'centen'=>$s_tel['svecenten'],'type'=>$s_tel['svetype'],'v' => $s_tel['svegailv']*1000000),
						'7' => array('id' => 8,  'goumai' => $s_tel['egishiwu'],'pic' => $s_tel['egipic'],'text' => $s_tel['egitext'], 'name'=>'egi','num'=>$s_tel['eginum'],'centen'=>$s_tel['egicenten'],'type'=>$s_tel['egitype'],'v' => $s_tel['egigailv']*1000000),
					);
					//dump($prize_arr);
					foreach ($prize_arr as $k=>$v) {
						if($v['num']) $arr[$v['id']] = $v['v'];

					}

					$prize_id = $this->getRand($arr); //根据概率获取奖项id
					foreach($prize_arr as $k=>$v){ //获取前端奖项位置
						if($v['id'] == $prize_id){
						 $prize_site = $k;
						 break;
						}
					}
					$res = $prize_arr[$prize_id - 1]; //中奖项 

					$datac['prize_name'] = $res['text'];
					$datac['type']=$res['type'];
					$datac['centen']=$res['centen'];
					$datac['prize_site'] = $prize_site;//前端奖项从-1开始
					$datac['prize_id'] = $prize_id;
					
					//写入抽奖记录 
					$cjjlldata['ctime']=time();
					$cjjlldata['duij']=0;
					//红包优惠券自动兑奖
					if($res['type']==2) {
						$cjjlldata['duij']=1;
						//添加会员优惠券
						$hyqqdata['uid']=$user['id'];
						$hyqqdata['jine']=$res['centen'];
						
						$nnpn=($this->config);
						$nnpn=$nnpn['zssdjjedyxq']*86400;
						$nnpn=$nnpn+time();
						$hyqqdata['etime']=$nnpn;
						
						$nnpn=($this->config);
						$nnpn=$nnpn['gwdjqq'];
						$hyqqdata['xe']=$nnpn;
						$hyqadd=M('huiyouhuiq')->add($hyqqdata);
						
						
					}
					//但不是3谢谢惠顾模式
					if($res['type']==1) $cjjlldata['duim']=date('Ymd').$user['id'].$this->generate_rand_zmdx(10);//.$this->getip().$res['type'];
					//奖品减少
					if($res['type']!=3){
						
						$name=$res['name'];
						$jsw['id']=$id;
						$jsdata[$name.'num']=($res['num']-1)+0;
						$jsm=M('hcjhd')->where($jsw)->save($jsdata);
					}
					//dump($res);
					$cjjlldata['pic']=$res['pic'];
					$cjjlldata['uid']=$user['id'];
					$cjjlldata['goumai']=$res['goumai'];
					$cjjlldata['tel']=$user['tel'];
					$cjjlldata['info']=$res['text'];
					$cjjlldata['centen']=$res['centen'];
					$cjjlldata['type']=$res['type'];
					$cjjlldata['cjtitle']=$s_tel['ttielll'];//抽奖活动标题
					$rscjjll=M('cjjll')->add($cjjlldata);
					
					
					
					echo json_encode($datac);
					exit;
				}

			/*end*/
		
		
		
		
		
		$this->assign ( 's', $s_tel );
		//dump($s_tel);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/LuckDraw.html' );
	}
	//检查登录状态-不跳转
	function jjccddll_noj(){
		$id=$_COOKIE["tel"]+0;
		$logg=$_COOKIE["logg"];
		if(!$id || !$logg) {		
			setcookie("tel", 0, time()-3600000);
			setcookie("logg", 0, time()-3600000);
			//header('Location:/index.php?s=/addon/WeiSite/WeiSite/login.html');
		}
		if($id && $logg){
			$mapc['id']=$id;
			$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
			
					//获取今天的时间
					$n_data=date('Ymd');
					//会员今天登录时间
					$h_data=$s_tel['0']['dtime'];
					//会员今天是否已经抽奖 dcjsf
					if($h_data!=$n_data){//会员今天第一次登录
						$data['dtime']=$n_data;
						
						$nnpncjzssdd=($this->config);
						$nnpncjzssdd=$nnpncjzssdd['cjzssdd']+0;
						$data['dcjsf']=$nnpncjzssdd;
						$data['mflqyhq']=1;
						$w['id']=$s_tel['0']['id'];
						$ddm=M('huiyuan')->where($w)->save($data);
					}
			
			$s_logg=($s_tel['0']['logg']);
			$s_saltr=($s_tel['0']['saltr']);
			$s_mTime=($s_tel['0']['mTime']);
			$s_rip=$this->getip();
			
			$s_new_logg=md5($s_rip.$s_saltr);//md5($s_rip.$s_mTime.$s_saltr);
			
			if($s_new_logg!=$s_logg || $logg!=$s_logg || !$s_tel['0']['tel']) {
				setcookie("tel", 0, time()-3600000);
				setcookie("logg", 0, time()-3600000);
				//header('Location:/index.php?s=/addon/WeiSite/WeiSite/login.html');
			}
			
			$newuser=array();
			$newuser['id']=$id;
			$newuser['tel']=$s_tel['0']['tel'];
			return $newuser;
		}
	}
	//获取购物车数量
	function ssggwwnum(){
		if(!$_COOKIE["tel"]) $ggwwnumber=0;
		else{
			$user=$this->jjccddll_noj();
			$sm['uid']=$user['id'];
			$sm['ok']=0;
			$sp=M('dingdantem')->where($sm)->select();
			$ggwwnumber=count($sp);
		}
		return $ggwwnumber;
	}
	//购买--购物车
	function shooppcaa(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html';
			$_SESSION['lijigoumaishangpinid']=0;
			$_SESSION['gm_yhq_id']=0;
			$_SESSION['MyCouponsNewUsy']=0;
			$_SESSION['syhhq_xxeennpn']=0;
			$_SESSION['xxeennpnzzss']=0;
			$_SESSION['new_Total_fee']=0;
				$_SESSION['bdddbzxlddgllldzsyhdduuu']=''; //订单蛋糕制作备注 2016.8.27
		
		$user=$this->jjccddll();
		//$id=$user['id'];
		$tel=$user['tel'];
		//获取会员商品订单
		$sm['uid']=$user['id'];
		$sm['ok']=0;
		
		if(!$_SESSION['jiangpianduihwdccid']){
			$smsm['uid']=$user['id'];
			$smsm['ok']=0;
			$smsm['jiage']=array('eq',0);
			$sp=M('dingdantem')->where($smsm)->delete();
		}
		
		$sp=M('dingdantem')->where($sm)->select();
		$this->assign ( 'sp', $sp);
		//dump($sp);
		//运费
		$nnpn=($this->config);
		$nnpn=$nnpn['yunfei'];
		$this->assign ( 'yunfei', $nnpn+0);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/shooppcaa.html' );
	}
	//去重复元素
	function a_array_unique($array)//写的比较好
	{
	   $out = array();
	   foreach ($array as $key=>$value) {
		   if (!in_array($value, $out))
	{
			   $out[$key] = $value;
		   }
	   }
	   return $out;
	} 
	
	
	
	//立即购买、立即抢购
	function lijigoumaiqianggou(){
		$sid=I ( 'sid', 0, 'intval' );//商品id
		$chicun=I ( 'chicun', 0, 'strip_tags' );
			$fuqshifoufanwang=$this->huoquxianjieudanzhifurenshu();
			if($fuqshifoufanwang) exit('Server busy..');
				$smyyy['id']=$sid;
				$yyzee=M('custom_reply_news')->where($smyyy)->limit(0,1)->select();
			
				$newcpnumnum=$yyzee['0']['cpnum'];//数量
				if($yyzee['0']['qianggou']){
					$newcpnumnum=$yyzee['0']['qgnum'];
				}
				if($newcpnumnum<1) exit('nonumxxoo');
			
		//$_SESSION['lijigoumaishangpinid']=($sid+0);
		//$_SESSION['lijigoumaishangpinidchicun']=$chicun;
		header('Location:/index.php?s=/addon/WeiSite/WeiSite/SubmitOrder/index.html');
		exit;
	}
	//获取现阶段支付人数
	function huoquxianjieudanzhifurenshu(){
		$user=$this->jjccddll();
		$zt=180;//支付时间
		$zr=60;//支付人数
		$hw['fuk']=0;
		$hw['ctime']=array('gt',time()-$zt);
		$hr=M('dingdan')->where($hw)->select();
		$hn=count($hr);
		$nok=0;
		if($hn>$zr) $nok=$hn;//提示服务器繁忙
		return $nok;
		//dump($hr);
	}
	//扫描支付
	function qcoder(){
		$dz=I ( 'dz', 0, 'strip_tags' );
		
		
		//2016.8.27
		
		$rokchacekkzhifudingdan=$this->chacekkzhifudingdan();
		if(!$rokchacekkzhifudingdan && !$dz && ($_SESSION['chongzhi_mod']==2)){
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/e.html' );
			exit;
		}
		//end
		
		sleep(1);
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		//查询是否支付
		
		if('ok'===$dz){
			
			if(!$rokchacekkzhifudingdan && ($_SESSION['chongzhi_mod']==2)){
				echo 'no';
				exit;
			}
			sleep(1);
			
			$jjyyy['anquanmsalt']=$_SESSION['anquanmsalt'];
			$jjyyy['tel']=$user['tel'];
			$jjyyy['uid']=$user['id'];
			$jjyymmm=M('finance')->where($jjyyy)->find();
			
			if(!$jjyymmm || !$_SESSION['anquanmsalt']){
				
				//dump($jjyyy);
				exit;
			}
			if($jjyymmm['jine']) {
				echo $jjyymmm['leixin'];
				//$_SESSION['anquanmsalt']=0;
				exit;
			}
		}
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/qcoder.html' );
	}
	//立即购买--提交订单
	function SubmitOrder(){
		
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		//$id=$user['id'];
		$tel=$user['tel'];
		//获取会员余额
		$mapcyu['uid']=$user['id'];
		$syu=M('recharge')->where($mapcyu)->limit(0,1)->select();
		//$_SESSION['new_Total_fee_yue']=$syu['0']['yue'];
		
		//dump($syu['0']['yue']);exit;
		//获取会员商品订单
		$sm['uid']=$user['id'];
		$sm['ok']=0;
		//删除非奖品兑换
		if(!$_SESSION['jiangpianduihwdccid']){
			$smsm['uid']=$user['id'];
			$smsm['ok']=0;
			$smsm['jiage']=array('eq',0);
			$spddd=M('dingdantem')->where($smsm)->delete();
		}
		
		//立即购买
		if($_SESSION['lijigoumaishangpinid']){
			$sm['id']=$_SESSION['lijigoumaishangpinid'];
			//$sm['chicun']=$_SESSION['lijigoumaishangpinidchicun'];
			$smup['id']=$sm['id'];
			//$smup['chicun']=$sm['chicun'];
		}
		
		
		$jsok=I('get.jsok','','strip_tags');
		//echo $jsok;exit;
		$sp=M('dingdantem')->where($sm)->select();//临时订单
		
		
		//获取收获地址
		$mapc['uid']=$user['id'];
		$dzs=M('shouhuodizi')->where($mapc)->order('mor desc,id desc')->select();
		//dump($dzs);exit;
	
		
		//获取会员优惠券
		$mapcssh['uid']=$user['id'];
		$mapcssh['ok']=0;
		//echo $_SESSION['gm_yhq_id'];exit;
		if($_SESSION['gm_yhq_id']) $mapcssh['id']=$_SESSION['gm_yhq_id'];
		
		
		//修复优惠券前台显示bug 2016.8.27
		$mapcssh['etime']=array('gt',time());
		
		
		
		
		
		
		
		$dzsyh=M('huiyouhuiq')->where($mapcssh)->order('jine asc ,etime asc')->select();
		if(!$_SESSION['gm_yhq_id']) $_SESSION['gm_yhq_id']=$dzsyh['0']['id'];
		//if(empty($dzsyh)) $_SESSION['gm_yhq_id']=0;
		//dump($dzsyh);exit;

			//$_SESSION['dzsyhdzsyhdzsyhdzsyh']=$dzsyh;
		
		
		
		//运费
		$nnpn=($this->config);
		$nnpn=$nnpn['yunfei'];
		
		
		foreach($sp as $k=>$v){
			if(!$k) $sid_all=$v['sid'];
			$sid_all=$sid_all.','.$v['sid'];
			
			if(!$k) $sid_alls=$v['id'];
			$sid_alls=$sid_alls.','.$v['id'];
			
			//总数量
			$znum=$znum+$v['num'];
			//总金额
			$zjne=$zjne+($v['num']*$v['jiage'])+0;
			//商品详情
			//如果是抢购商品
			$sfqignggttle='';
			if($v['qtime']) $sfqignggttle='【抢购商品】';
			$zxq=$zxq.'商品名称：'.$sfqignggttle.$v['title'].' 数量：'.$v['num'].' 尺寸：'.$v['chicun'].'<br>';
			
		}

			//使用条件
			$nnpnress=($this->config);
			$nnpnxxee=$nnpnress['djqshiyongxianer'];
			$nnpnxxee=str_ireplace("\r\n",'#',$nnpnxxee);
			$nnpnxxee=str_ireplace("购",'',$nnpnxxee);
			$nnpnxxee=explode("#",$nnpnxxee);
			foreach ($nnpnxxee as &$vsfsd) {
				$vsfsd = str_ireplace(' ','',$vsfsd);
			}
			$xxeennpn=array_search($dzsyh['0']['jine'],$nnpnxxee);
			if($xxeennpn) $xxeennpn=$nnpnxxee[($xxeennpn-1)];
			$_SESSION['syhhq_xxeennpn']=$xxeennpn;
			
			
			
			

			
			
			
			
			
			
			
			
			
			//$hyqqdata['xe']=$xxeennpn;
			//$hyqadd=M('huiyouhuiq')->add($hyqqdata);
		
		//$nnpnssss=($this->config);
		$nnpnssss=$xxeennpn;//$nnpnssss['gwdjqq'];
		$vipzjjnn=$zjne;//需付款金额
		$viphyzjne=0;//VIP优惠
		$vipzjne=$zjne;//余额支付 非vip付款
		if($user['vip']){
			
			$vipcegg=$this->config;
			$vipcegg=$vipcegg['vipcegg']/10;
			$vipzjne=$zjne*$vipcegg;
			$vipzjne=sprintf("%.2f", $vipzjne);
			//vip优惠
			$viphyzjne=$vipzjjnn-$vipzjne;
		}
		

		//$_SESSION['new_Total_fee']=$zjne;
		
			//赠送条件
			$nnpnresszs=($this->config);
			$nnpnxxeezs=$nnpnresszs['zsdjqxianer'];
			$nnpnxxeezs=str_ireplace("\r\n",'#',$nnpnxxeezs);
			$nnpnxxeezs=str_ireplace("送",'',$nnpnxxeezs);
			$nnpnxxeezs=explode("#",$nnpnxxeezs);
			foreach ($nnpnxxeezs as &$vsfsdzs) {
				$vsfsdzs = str_ireplace(' ','',$vsfsdzs);
			}
			foreach($nnpnxxeezs as $kss=>$vsdfzs){
				if(!($kss%2)){
					if($nnpnxxeezs[($kss)]<=$_SESSION['new_Total_fee']){
						$xxeennpnzzss=$nnpnxxeezs[($kss+1)];//赠送优惠券金额
					}
				}
			}
			//$_SESSION['nnpnxxeezsnnpnxxeezs']=$nnpnxxeezs;
			
			$_SESSION['xxeennpnzzss']=$xxeennpnzzss;
			//$xxeennpn=array_search($dzsyh['0']['jine'],$nnpnxxee);
			//if($xxeennpn) $xxeennpn=$nnpnxxee[($xxeennpn-1)];
			//$_SESSION['syhhq_xxeennpn']=$xxeennpn;
		
		
		
		
		
		
		
		
		
		
		
		
		//$_SESSION['nnpnssss']=$nnpnssss;
		if($vipzjjnn<$nnpnssss){
			$dzsyh['0']['id']=0;
			$dzsyh['0']['jine']=0;
		}
		
		//优惠券id
		//$_SESSION['gm_yhq_id']=$dzsyh['0']['id'];
		
		
		
		
		
		//$_SESSION['zxq']=$zxq;
		
			//if($_SESSION['dzsyhdduuu'])
		$_SESSION['user_id']=$user['id'];
		$_SESSION['user_tel']=$user['tel'];

		$dz=I ( 'dz', 0, 'strip_tags' );//地址
		$fanwei=I ( 'post.fanwei', 0, 'strip_tags' );
		//echo $dz;exit;
		$yhq=I ( 'yhq', 0, 'strip_tags' );//是否使用优惠券
		$_SESSION['gm_yhq']=0;
		
		//优惠券bug 2016-07-28
		$jsdata['yhq']=0;
		
		if($yhq) {
			$jsdata['yhq']=$dzsyh['0']['jine'];
			$_SESSION['gm_yhq']=$dzsyh['0']['jine'];
		}
		
		//货到付款
		$_SESSION['randomdaofu']=0;
		$randomdaofu=I ( 'hdfk', 0, 'strip_tags' );
		if($randomdaofu) {
			$_SESSION['randomdaofu']=1;
		}
		
		$_SESSION['gm_yue']=0;
		$yue=I ( 'yue', 0, 'strip_tags' );//是否使用余额
		if($yue) {
			$jsdata['yue']=1;
			$_SESSION['gm_yue']=1;
		}
		else $viphyzjne=0;
		//$_SESSION['fanwei']=$fanwei;
		$zxq=$zxq.'总数量：'.$znum.'件 总金额：'.($vipzjjnn).'元 运费：'.$nnpn.'元';
		if(!$jsok) $_SESSION['new_Total_fee']=($zjne+$nnpn);//-$dzsyh['0']['jine']);//-$viphyzjne);//购买测试
		
		$_SESSION['new_Total_fee_nnpn']=$nnpn;
		if($fanwei && $jsok==='ok') {
			$_SESSION['new_Total_fee']=$_SESSION['new_Total_fee']-$nnpn;
			$_SESSION['new_Total_fee_nnpn']=0;
		}
		$yue_n=$syu['0']['yue'];//会员余额
		/*if($jsok==='ok'){
			echo $_SESSION['new_Total_fee'];
			exit;
		}*/
		//echo $_SESSION['new_Total_fee']; 
		
		//修复优惠券直接读取数据库bug
		$ssshhhjjnn=$zjne-$viphyzjne+$_SESSION['new_Total_fee_nnpn']-$jsdata['yhq'];//-$dzsyh['0']['jine'];
		//$ssshhhjjnn=$zjne-$viphyzjne+$_SESSION['new_Total_fee_nnpn']-$dzsyh['0']['jine'];
		
		//结算，写入订单
		$jsdata['viphy']=$viphyzjne;
		$jsdata['youfei']=$_SESSION['new_Total_fee_nnpn'];
		$jsdata['shjne']=$ssshhhjjnn;//$_SESSION['new_Total_fee'];
		$jsdata['goumaisp']=$zxq;//商品详情
		$jsdata['uid']=$user['id'];
		$jsdata['ctime']=time();
		$jsdata['zhuantai']=0;//未发货
		$jsdata['fuk']=0;//未付款
		//$jsdata['daijinquan']=$dzsyh['0']['jine'];//代金券
		$jsdata['zongjine']=$vipzjjnn;
		$jsdata['shouhuodz']=$dz;//收获地址
		//dump($sp);
		$jsdata['sid']=$sid_all;
		$jsdata['pic']=$sp['0']['pic'];
		$jsdata['xpic']=$sp['0']['sid'];
		$jsdata['wallid']=$sid_alls;
		$jsdata['tel']=$user['tel'];
		$jsdata['qtime']=$sp['0']['qtime']+0;
		$jsdata['paaasssrrii']=I ( 'paaasssrrii', 0, 'strip_tags' );
		$jsdata['sssxxssdd']=I ( 'sssxxssdd', 0, 'strip_tags' );
		$jsdata['bssxxxssd']=I ( 'bssxxxssd', 0, 'strip_tags' );
		$jsdata['peissfaina']=I ( 'peissfaina', 0, 'strip_tags' );
		if(!$jsdata['peissfaina']) $jsdata['peissfaina']=2;
		$jsdata['bdddbz']=I ( 'bdddbz', 0, 'strip_tags' );
		
		
		
			//获取订单最新订单号
			$hhhssuuzx=M('dingdan')->order('id desc')->limit(0,1)->select();
		$jsdata['dingdanbianhao']='ainastea-'.($hhhssuuzx['0']['id']+1);
		//md5(time().$_SESSION['new_Total_fee'].$user['id'].$user['tel'].rand(100000,999999));//订单编号
		
			M('dingdan_copy')->add($jsdata);//2016.08.25
		if($jsok==='ok' && $sid_alls){
			$result = M('dingdan')->add($jsdata);//2016.05.13
			
			if($result){
					$_SESSION['chongzhi_mod']=2;//类型充值1 购买2
					$_SESSION['chongzhi_sid']=$result;
						//更新临时订单
						$smup['uid']=$user['id'];
						$smup['ok']=0;
						$smupdata['ok']=2;//未付款商品
						$supp=M('dingdantem')->where($smup)->save($smupdata);//临时订单
						//$_SESSION['chongzhi_sid']
						if($supp) {
							$_SESSION['lijigoumaishangpinid']=0;
							header('Location:/index.php?s=/addon/WeiSite/WeiSite/fukokkk/index.html');
							//  /weixin/example/jsapi.php
							exit;
						}
						
			}
		}
		
		//echo $_SESSION['new_Total_fee'];
			//今天配送满关闭今天配送额度
			$random = getAddonConfig ( 'DingDan' );
			$random =$random['random'];
			
			if(!$random) $random='+1';
			else $random='';
			$this->assign ( 'syu', $syu['0']['yue']);
			$this->assign ( 'sp', $sp);
			$this->assign ( 'dzs', $dzs );
			$this->assign ( 'yunfei', $nnpn);
			$this->assign ( 'vipzjne', $vipzjne );
			$this->assign ( 'vipzjjnn', $vipzjjnn );
			$this->assign ( 'viphyzjne', $viphyzjne );
			$this->assign ( 'dzsyhde', $dzsyh['0']['jine'] );
			$this->assign ( 'znum', $znum);
			$this->assign ( 'zjne', $zjne);
			$this->assign ( 'random', $random);
		//dump($sp);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/SubmitOrder.html' );
	}
	
	//礼品兑换购买
	function lipinduihuangoumai(){
		$user=$this->jjccddll();
		$goumai=I('goumai','0','strip_tags');
		$goumai=explode('iswtfcom',$goumai);
		//dump($goumai);
		
		//更新已兑换
		$wcj['id']=$goumai['2'];
		$newwcjarray=explode(',',$_SESSION['jiangpianduihwdccid']);
		//$_SESSION['jiangpianduihwdccidnewwcjarray']=$newwcjarray;
		if($newwcjarray && $wcj['id']){
			if(!in_array($wcj['id'],$newwcjarray)){
				if($_SESSION['jiangpianduihwdccid']) $_SESSION['jiangpianduihwdccid'].=','.$wcj['id'];
				else $_SESSION['jiangpianduihwdccid']=$wcj['id'];
			}
			else{
				//$_SESSION['jjppddhhhssann']=0;
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html');exit;
				return true;
			}
		}
		if(empty($newwcjarray) && $_SESSION['jiangpianduihwdccid']==$wcj['id']){
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html');
			exit;
		}
		
		
		//获取会员抽奖记录
		$mapc['uid']=$user['id'];
		$mapc['id']=$wcj['id'];
		$s_tel=M('cjjll')->where($mapc)->limit('0,1')->select();
		//$new_sf_aaaaa['duim']=$s_tel['0']['duim'];
		//$_SESSION['jiangpianduihwdccidnewwcjarray']=$s_tel['0']['duim'];
		$mapcsss['duim']=$s_tel['0']['duim'];
		$mapcsss['uid']=$user['id'];
		
		if($s_tel['0']['guoqi']){
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/index.html');
			exit;
		}
		
		if($s_tel['0']['duim']) 
			$s_teldingdantem=M('dingdantem')->where($mapcsss)->delete();
		/*$_SESSION['jiangpianduihwdccidnewwcjarray']=$s_teldingdantem;
		if($s_tel['0']['duim']) $s_teldingdantem=M('dingdantem')->where($mapcsss)->limit('0,1')->select();
		if($s_teldingdantem['0']['id']){*/
		else{
			//$mapcsssddd['duim']=$mapcsss['duim'];
			//$s_teldingdantemsss=M('dingdantem')->where($mapcsssddd)->delete();
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html');
			exit;
		}
		
		
		$smyyy['id']=$goumai['0'];
		$yyzee=M('custom_reply_news')->where($smyyy)->limit(0,1)->select();
		
		$dtmp['tel']=$user['tel'];
		$dtmp['sid']=$goumai['0'];
		$dtmp['uid']=$user['id'];
		$dtmp['ctime']=time();
		$dtmp['chicun']=$goumai['1'];
		$dtmp['ok']=0;
		$dtmp['num']=1;
		$dtmp['pic']=$yyzee['0']['cover'];
		$_SESSION['jjppddhhhssann']=1;
		$dtmp['title']='【奖品兑换】'.$yyzee['0']['title'];
		$dtmp['jiage']=0;
		$dtmp['duim']=$mapcsss['duim'];
		$ddtmp=M('dingdantem')->add($dtmp);

		//$cjdata['duij']=1;
		//$ddcccjj=M('cjjll')->where($wcj)->save($cjdata);
		
		header('Location:/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html');exit;


		//echo $goumai;
	}
	
	
	
	//错误页面 2016.8.27
	function dingdanyichangcuowuyemians(){
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/dingdanyichangcuowuyemians.html' );
		exit;
	}
	function dingdanyichaneeens(){
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/e.html' );
		exit;
	}
	//正在检测支付环境  检测订单是否丢失 2016.8.27
	function chacekkzhifudingdan(){
		if($_SESSION['chongzhi_mod']==2) {
			//$new_body='购买';
			//$nurll='/index.php?s=/addon/WeiSite/WeiSite/ggwwwwok/index.html';
			//$_SESSION['chongzhi_sid'] 新订单id
			$where['id']=$_SESSION['chongzhi_sid'];
			$r=M('dingdan')->where($where)->limit(1)->select();
			//dump($r);
			$r=$r['0'];
			$rok=1;
			if(!$r['shouhuodz'] || !$r['id'] || !$r['tel'] || !$r['goumaisp'] || !$r['dingdanbianhao'] || !$r['paaasssrrii'] || !$r['sssxxssdd'] || !$r['bssxxxssd'] || !$r['peissfaina']){
				$rok=0;
				//return false;//订单信息丢失异常
			}
			return $rok;
		}
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//提交付款
	function fukokkk(){
		
		//2016.8.27
		$rokchacekkzhifudingdan=$this->chacekkzhifudingdan();
		if(!$rokchacekkzhifudingdan){
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/e.html' );
			exit;
		}
		//end
		
		$user=$this->jjccddll();

		
		//货到付款
		
		if($_SESSION['randomdaofu']){
				$viphyzjne=0;
				if($user['vip']){
					//echo $_SESSION['new_Total_fee'];exit;
					$vipcegg=$this->config;
					$vipcegg=$vipcegg['vipcegg']/10;
					$vipzjne=($_SESSION['new_Total_fee']-$_SESSION['new_Total_fee_nnpn'])*$vipcegg;
					$vipzjne=sprintf("%.2f", $vipzjne);
					//vip优惠
					$viphyzjne=$_SESSION['new_Total_fee']-$vipzjne;
					
					$_SESSION['new_Total_fee']=$vipzjne+$_SESSION['new_Total_fee_nnpn'];
					$_SESSION['new_Total_fee_nnpn']=0;
				}
					$dzsyh_id=0;
					$nnpnssssaaa=($this->config);
					$nnpnssssaaa=$_SESSION['syhhq_xxeennpn'];//$nnpnssssaaa['gwdjqq'];
					if(($_SESSION['new_Total_fee']+$viphyzjne)>=$nnpnssssaaa){
						$dzsyh_id=1;
						//$dzsyh['0']['jine']=0;
						
					}
				
					$dzsyh_id_ss=0;
					$nnpnssssaassa=($this->config);
					$nnpnssssaassa=$nnpnssssaassa['gwdjqqzs'];
					if(($_SESSION['new_Total_fee']+$viphyzjne)>$nnpnssssaassa){
						$dzsyh_id_ss=1;
						//$dzsyh['0']['jine']=0;
					}
				
				
				//赠送优惠券
				if(!$_SESSION['gm_yhq'] && $_SESSION['xxeennpnzzss']) $this->zshyqqq();
				if($_SESSION['gm_yhq'] && $dzsyh_id) {
					$this->shiyongyyqq();
					$_SESSION['new_Total_fee']=$_SESSION['new_Total_fee']-$_SESSION['gm_yhq'];
				}
				
				//添加财务记录
				$this->tjdaoccwwjll(2,'货到付款');
				$this->gdxxddfuk();
				
			$_SESSION['gm_yhq_id']=0;
			$_SESSION['MyCouponsNewUsy']=0;
			$_SESSION['syhhq_xxeennpn']=0;
			$_SESSION['xxeennpnzzss']=0;
			$_SESSION['new_Total_fee']=0;
		
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/Myordernew/index.html');exit;
			return false;
		}
		
		

		
		
		
		
		
		
		
		

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		//余额购买
		if($_SESSION['gm_yue'] || !$_SESSION['new_Total_fee']){
			$mapcyu['uid']=$user['id'];
			$syu=M('recharge')->where($mapcyu)->limit(0,1)->select();
			$rw['uid']=$user['id'];
				$viphyzjne=0;
				if($user['vip']){
					//echo $_SESSION['new_Total_fee'];exit;
					$vipcegg=$this->config;
					$vipcegg=$vipcegg['vipcegg']/10;
					$vipzjne=($_SESSION['new_Total_fee']-$_SESSION['new_Total_fee_nnpn'])*$vipcegg;
					$vipzjne=sprintf("%.2f", $vipzjne);
					//vip优惠
					$viphyzjne=$_SESSION['new_Total_fee']-$vipzjne;
					
					$_SESSION['new_Total_fee']=$vipzjne+$_SESSION['new_Total_fee_nnpn'];
					$_SESSION['new_Total_fee_nnpn']=0;
				}
			
			$rd['yue']=$syu['0']['yue']-($_SESSION['new_Total_fee']-$_SESSION['gm_yhq']);
			$rd['tel']=$user['tel'];
			$rd['mtime']=time();
			$rsa=M('recharge')->where($rw)->save($rd);
			//if($rsa){
				
					$dzsyh_id=0;
					$nnpnssssaaa=($this->config);
					$nnpnssssaaa=$_SESSION['syhhq_xxeennpn'];//$nnpnssssaaa['gwdjqq'];
					if(($_SESSION['new_Total_fee']+$viphyzjne)>=$nnpnssssaaa){
						$dzsyh_id=1;
						//$dzsyh['0']['jine']=0;
						
					}
				
					$dzsyh_id_ss=0;
					$nnpnssssaassa=($this->config);
					$nnpnssssaassa=$nnpnssssaassa['gwdjqqzs'];
					if(($_SESSION['new_Total_fee']+$viphyzjne)>$nnpnssssaassa){
						$dzsyh_id_ss=1;
						//$dzsyh['0']['jine']=0;
					}
				
				
				//赠送优惠券
				if(!$_SESSION['gm_yhq'] && $_SESSION['xxeennpnzzss']) $this->zshyqqq();
				if($_SESSION['gm_yhq'] && $dzsyh_id) {
					$this->shiyongyyqq();
					$_SESSION['new_Total_fee']=$_SESSION['new_Total_fee']-$_SESSION['gm_yhq'];
				}
				
				//添加财务记录
				$this->tjdaoccwwjll(2,'余额购买');
				$this->gdxxddfuk();
				
				$_SESSION['gm_yhq_id']=0;
				$_SESSION['MyCouponsNewUsy']=0;
				$_SESSION['syhhq_xxeennpn']=0;
				$_SESSION['xxeennpnzzss']=0;
				$_SESSION['new_Total_fee']=0;
				
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/Myordernew/index.html');exit;
			//}
		}
		else{
			$_SESSION['anquanmsalt']=rand(100000,999999);
			$_SESSION['new_Total_fee']=($_SESSION['new_Total_fee']-$_SESSION['gm_yhq'])*100;
			if($_SESSION['new_Total_fee']<1) $_SESSION['new_Total_fee']=1;
			
			//2016.09.08 //优惠券有效期
			$nnpnyouhuiquanyouxiaoqi=($this->config);
			$nnpnsyouhuiquanyouxiaoqi=$nnpnyouhuiquanyouxiaoqi['zssdjjedyxq']*86400;
			$_SESSION['nnpnsyouhuiquanyouxiaoqi']=$nnpnsyouhuiquanyouxiaoqi;
			
			$_SESSION['jiudeyouhuiquanyouxiaoqixe']=$nnpnyouhuiquanyouxiaoqi['gwdjqq'];
		
			
			
			//end
			
			header('Location:/zf.html');
			exit;
		}
		
		//dump($_SESSION);exit;
	}
	
	function Myordernew(){

		
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/SubmitOrder.html';
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		//全部订单
		$mydd['uid']=$user['id'];
		//待付款 
		$dfk=I ( 'get.dfk', 0, 'strip_tags' );
		
		$this->assign ( 'dfk', $dfk );
		if($dfk==='dfk') $mydd['fuk']=array('eq','0');
		if($dfk==='dsh') {
			$mydd['fuk']='已付款';//array('neq','0');
			$mydd['queren']=array('eq','0');
		}
		if($dfk==='dfkok') $mydd['queren']=1;
		
		$mys=M('dingdan')->where($mydd)->order('id desc')->limit(0,9)->select();
		$this->assign ( 'mys', $mys );
		//取消订单
		$quxiao=I ( 'quxiao', 0, 'intval' );
		if($quxiao){
			$qw['id']=$quxiao;
			$qw['uid']=$user['id'];
			$myq=M('dingdan')->where($qw)->delete();
		}
		//确认收货
		$quren=I ( 'quren', 0, 'intval' );
		//echo $quren;exit;
		if($quren){
			$qw['id']=$quren;
			$qw['uid']=$user['id'];
			$qd['queren']=1;
			$myq=M('dingdan')->where($qw)->save($qd);
			//dump($qw);exit;
		}
		
		
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/Myordernew.html' );
	}
	
	//更新订单已付款
	function gdxxddfuk(){
		
		$user=$this->jjccddll();
		
			//更新会员抽奖次数
			
				$nnpncjzssddggzzggmm=($this->config);
				$nnpncjzssddggzzggmm=$nnpncjzssddggzzggmm['cjzssddggzzggmm']+0;
			$data['zcj'] = array('exp','zcj+'.$nnpncjzssddggzzggmm);
			$w['id']=$user['id'];
			$ddm=M('huiyuan')->where($w)->save($data);
		
		
		$fukw['uid']=$user['id'];
		$fukw['id']=$_SESSION['chongzhi_sid'];
		$fuk['daijinquan']=$_SESSION['gm_yhq']+0;
		
		$fuk['fuk']='已付款';
		if($_SESSION['randomdaofu']) $fuk['fuk']='货到付款';
		$fuk['mtime']=time();
		$fukas=M('dingdan')->where($fukw)->save($fuk);
		$this->fsyjemail();
		if($fukas) return true;
		else return false;
	}
	
	//添加到财务记录
	function tjdaoccwwjll($leix,$texx){
		$user=$this->jjccddll();
		$fd['uid']=$user['id'];
		$fd['bank_type']=$texx;
		if(!$_SESSION['new_Total_fee'] && $_SESSION['jjppddhhhssann']) $fd['bank_type']='奖品兑换';
		$fd['ok']=1;
		if(!$_SESSION['new_Total_fee'] && !$_SESSION['jjppddhhhssann']) $fd['ok']=0;
		if($_SESSION['randomdaofu']) $fd['ok']=0;
		$fd['tel']=$user['tel'];
		$fd['transaction_id']=$user['id'].time().rand(100,999);
		$fd['leixin']=$leix;
		$fd['jine']=$_SESSION['new_Total_fee'];
		$fd['ctime']=time();
		if($fd['uid'] && $fd['tel']) {
			$faa=M('finance')->add($fd);
			$faa=M('finance_copy')->add($fd);
		}
		$newwcjarray=explode(',',$_SESSION['jiangpianduihwdccid']);
		$cjdata['duij']=1;
		$wcj['id']=array('in',$newwcjarray);
		$ddcccjj=M('cjjll')->where($wcj)->save($cjdata);
		$_SESSION['jiangpianduihwdccid']=0;
		$_SESSION['jjppddhhhssann']=0;
		
		if($faa) return true;
		else return false;
	}

	//发送邮件
	function fsyjemail(){
		$user=$this->jjccddll();
		//$id=$_GET['id'];
		$url = "http://aina.test.resonance.net.cn/email.php?v".time();
		
			$nnpnresszs=($this->config);
			$nnpnxxeezs=$nnpnresszs['jieshouyousxddddd'];
			$jieshouyousxdddddfffzz=$nnpnresszs['jieshouyousxdddddfffzz'];
		$timefs=time()-(60*$jieshouyousxdddddfffzz);//email
		//echo time().'<br>';
		//echo $timefs;return;
		$fukw['ctime']=array('lt',$timefs);
		$fukw['email']=array('neq',1);
		$fukas=M('dingdan')->where($fukw)->select();
		foreach($fukas as $k=>$v){
			$c1='<p>配送日期：'.$v['paaasssrrii'].'</p>';
			$c1.='<p>首选时间段：'.$v['sssxxssdd'].'</p>';
			$c1.='<p>备选时间段：'.$v['bssxxxssd'].'</p>';
			$c1.='<p>订单备注：'.$v['bdddbz'].'</p>';
			
			$c1.='<p>优惠券：'.$v['yhq'].'</p>';
			$c1.='<p>VIP优惠：'.$v['viphy'].'</p>';
			
			if($v['peissfaina']==1) $v['peissfaina']='艾娜配送';
			if($v['peissfaina']==2) $v['peissfaina']='站点自提';
			$c1.='<p>配送方式：'.$v['peissfaina'].'</p>';
			//$t.='订单号: '.$v['dingdanbianhao'];
			$c.='<span style="color: yellow;background-color: #00415d;padding: 1px 8px;margin-right: 3px;">'.($k+1).'</span>订单号: '.$v['dingdanbianhao'].'<p>'.$v['goumaisp'].'</p><p>地址:'.$v['shouhuodz'].'</p><p>付款:'.$v['fuk'].$c1.'</p><p>下单时间:'.date('Y-m-d',$v['ctime']).'</p><p>实收金额：'.$v['shjne'].'元</p><hr>';
			
		}
		
		
		$t='订单数('.($k+1).') '.date('Y-m-d H:m',time());
		// 参数数组
		$post_data = array (
			't' => $t,
			'c' => $c,
			'e' => $nnpnxxeezs
		);
      
          //dump($post_data);return;
		  //echo $post_data['c'];
		  if(!empty($fukas)) {
				$json_data=$this->postData($url,$post_data);
				//$array=json_decode($json_data,true);
				if($json_data){
					$demail['email']=1;
					$fukas=M('dingdan')->where($fukw)->save($demail);
				}
		  }
		//$array=json_decode($json_data,true);
		//dump($post_data);
		
	}
    function postData($url, $data){      
        $ch = curl_init();      
        $timeout = 300;       
        curl_setopt($ch, CURLOPT_URL, $url);     
        curl_setopt($ch, CURLOPT_REFERER, "http://resonance.com.cn/");   //构造来路    
        curl_setopt($ch, CURLOPT_POST, true);      
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);      
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);      
        $handles = curl_exec($ch);      
        curl_close($ch);      
        return $handles;      
    }      
	
	
	//使用优惠券
	function shiyongyyqq(){
		$user=$this->jjccddll();
		$hyqqs['uid']=$user['id'];
		$hyqqs['id']=$_SESSION['gm_yhq_id'];
		//$nnpn=($this->config);
		$hyqqdata['ok']=1;
		$hyqadd=M('huiyouhuiq')->where($hyqqs)->save($hyqqdata);
		
		$_SESSION['gm_yhq_id']=0;
		$_SESSION['MyCouponsNewUsy']=0;
		$_SESSION['syhhq_xxeennpn']=0;
		if($hyqadd) return true;
		else return false;
		//if(!$hyqadd) exit($_SESSION['gm_yhq_id']);

	}
	//赠送优惠券
	function zshyqqq(){
		$_SESSION['new_Total_feeSDFASDFADS']='FADSFDASFADSF';
		$user=$this->jjccddll();
		$hyqqdata['uid']=$user['id'];
		$nnpn=($this->config);
		$hyqqdata['jine']=$_SESSION['xxeennpnzzss'];
		$nnpns=$nnpn['zssdjjedyxq']*86400;
		$nnpns=$nnpns+time();
		$hyqqdata['etime']=$nnpns;
		
		$nnpn=$nnpn['gwdjqq'];
		$hyqqdata['xe']=$nnpn;
		$hyqadd=M('huiyouhuiq')->add($hyqqdata);
		$_SESSION['xxeennpnzzss']=0;
		if($hyqadd) return true;
		else return false;
	}
	
	//从会员订单过来
	function wwwffkkkid(){
		$wwwffkkkid=I('get.id','0','intval');
		if(!$wwwffkkkid){
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html');
			exit;
		}
		$mapddcssh['id']=$wwwffkkkid;
		$dzsyhdduuu=M('dingdan')->where($mapddcssh)->limit(0,1)->select();
		if(!$dzsyhdduuu['0']['wallid']){
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html');
			exit;
		}
		$_SESSION['bdddbzxlddgllldzsyhdduuu']=$dzsyhdduuu['0']['bdddbz']; //2016.8.27
		$smd['ok']=0;
		$sm['id']=array('in',$dzsyhdduuu['0']['wallid']);
		$sp=M('dingdantem')->where($sm)->save($smd);
		$ddel=M('dingdan')->where($mapddcssh)->delete();
		if($ddel) {
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/SubmitOrder/index.html');exit;
		}
	}
	
	
	//订单详情
	function OrderDetails(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$mydd['uid']=$user['id'];
		$id=I('get.id','','intval');
		$mydd['id']=$id;
		$mys=M('dingdan')->where($mydd)->select();
		$mys['0']['daijinquan']=$mys['0']['daijinquan']+0;
		$nnpn=($this->config);
		$nnpn_yunfei=$nnpn['yunfei'];
		$this->assign ( 'nnpn_yunfei', $nnpn_yunfei );
		$this->assign ( 'mys', $mys['0'] );
		//dump($mys);

		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/OrderDetails.html' );
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//交易记录
	function TransactionRecord(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$mapcjl['uid']=$user['id'];
		$sjl=M('finance')->where($mapcjl)->order('id desc')->select();
		$this->assign ( 'sjl', $sjl);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/TransactionRecord.html' );
	}
	//最新抽奖
	function zxcjj(){
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );
		
		$user=$this->jjccddll();
		$this->assign ( 'loandcss', 'DynamicActivity' );
		$this->assign('xltitle','最新抽奖-艾娜西点');
		$this->assign('keyword','最新抽奖,艾娜西点');
		$this->assign('intro','最新抽奖-艾娜西点');
		$zw['cjbegin']=array('lt',time());
		$zw['cjend']=array('gt',time());
		$info = M ( 'hcjhd' )->where($zw)->order('id desc')->select ();
		$this->assign ( 'info', $info );
		//dump($info);
		//$nnpn=($this->config);
		//$nnpn=999999;//$nnpn['cooajax'];
		//获取分类顶部图片
		//$mapimg['id']=14;
		//$infoimg = M ( 'weisite_category' )->where ( $mapimg )->find ();
		//$info ['img'] = get_cover_url ( $infoimg ['icon'] );

		//$this->assign ( 'info', $info );
		//$list_data=$this->lists(14,0,$nnpn);
		//$this->assign ( 'list_data_new', $list_data );
		//dump($list_data);
		//$this->_footer ();
		
		
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/zxcjj.html' );
	}
	
	/*
	function pesssming(){
		$random = getAddonConfig ( 'DingDan' );
		$random =$random['random'];
		//dump($random['random']);
		//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/pesssming.html' );
	}
	*/
	
	
	
	//购买成功更新
	function ggwwwwok(){
		$user=$this->jjccddll();
		
		//2016.09.08 是否已经付款
		/*$suppsfyjfkokledd['tel']=$user['tel'];
		$suppsfyjfkokledd['uid']=$user['id'];
		$suppsfyjfkokledd['id']=$_SESSION['chongzhi_sid'];
		$suppsfyjfkokle=M('dingdan')->where($suppsfyjfkokledd)->select();
		if($suppsfyjfkokle['0']['fuk']=='已付款'){
			$_SESSION['gm_yhq_id']=0;
			$_SESSION['MyCouponsNewUsy']=0;
			$_SESSION['syhhq_xxeennpn']=0;
			$_SESSION['xxeennpnzzss']=0;
			$_SESSION['new_Total_fee']=0;
			
			//使用优惠券
			$_SESSION['gm_yhq_id']=0;
			$_SESSION['MyCouponsNewUsy']=0;
			$_SESSION['syhhq_xxeennpn']=0;
		
			//赠送优惠券
			$_SESSION['xxeennpnzzss']=0;
			
			echo '已经付款';
			exit;
		}*/
		
		
			//检验
			$jjyyy['anquanmsalt']=$_SESSION['anquanmsalt'];
			$jjyyy['tel']=$user['tel'];
			$jjyyy['uid']=$user['id'];
			$jjyymmm=M('finance')->where($jjyyy)->find();
			if(!$jjyymmm || !$_SESSION['anquanmsalt']){
				//echo $_SESSION['anquanmsalt'];
				//header('Location:/weixin/example/jsapi.php');
				$_SESSION['anquanmsalt']=0;
				//dump($_SESSION);
				//2016.09.08
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/Myordernew/index.html');exit;
			}
		
		
			$nnpn=($this->config);
			$nnpn_gwdjqq=$_SESSION['syhhq_xxeennpn'];
			$nnpn_gwdjqqzs=$nnpn['gwdjqqzs'];
			if($_SESSION['gm_yhq'] && $_SESSION['new_Total_fee']>=$nnpn_gwdjqq){
				//使用优惠券 1
				$this->shiyongyyqq();
			}
			if(!$_SESSION['gm_yhq'] && $_SESSION['xxeennpnzzss']){
				//赠送优惠券
				$this->zshyqqq();
			}
		
			//更新会员抽奖次数
				$nnpncjzssddggzzggmm=($this->config);
				$nnpncjzssddggzzggmm=$nnpncjzssddggzzggmm['cjzssddggzzggmm']+0;
			$data['zcj'] = array('exp','zcj+'.$nnpncjzssddggzzggmm);
			
			
			//$data['zcj'] = array('exp','zcj+2');
			$w['id']=$user['id'];
			$ddm=M('huiyuan')->where($w)->save($data);
		//更新订单
		$dd['id']=$_SESSION['chongzhi_sid'];//购买测试
		//$dd['zongjine']=$_SESSION['new_Total_fee'];
		$dd['uid']=$user['id'];
		$smupdata['fuk']=0;
		
		//if($_SESSION['new_Total_fee']) $smupdata['fuk']='已付款';
		if($jjyymmm['jine']) $smupdata['fuk']='已付款';
		$smupdata['daijinquan']=$_SESSION['gm_yhq']+0;
		$smupdata['mtime']=time();
		$supp=M('dingdan')->where($dd)->save($smupdata);
		//dump($dd);
		//dump($smupdata);
			$_SESSION['gm_yhq_id']=0;
			$_SESSION['MyCouponsNewUsy']=0;
			$_SESSION['syhhq_xxeennpn']=0;
			$_SESSION['xxeennpnzzss']=0;
			$_SESSION['new_Total_fee']=0;
		if($supp) {
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/Myordernew/index.html');exit;
		}
		//echo 'fdasfads';
	}
	//更新购物车
	function JoinCartNew(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html';
		$user=$this->jjccddll();
		$mmoo=I ( 'mmoo', 0, 'strip_tags' );//购物车动作
		//$jiage=I ( 'jiage', 0, 'intval' );

		$d['uid']=$user['id'];
		
		//清空购物车
		if($mmoo=='delall'){
			$d['ok']=0;
			$result = M('dingdantem')->where($d)->delete();
			if($result) exit('ok');
		}
		$d['id']=I ( 'delsssid', 0, 'intval' );
		//删除
		if($mmoo=='del'){
			$result = M('dingdantem')->where($d)->delete();
			if($result) exit('ok');
		}
		//增加
		if($mmoo=='add'){
			$data['num'] = array('exp','num+1');
			$d['jiage'] = array('neq','0');
			$result = M('dingdantem')->where($d)->save($data);
				//获取抢购id
				$qgidmmmmm=M('dingdantem')->where($d)->limit(0,1)->select();
				$this->hhqqqgssnum($qgidmmmmm['0']['sid']);
				$this->hhqqqgssnumccss($qgidmmmmm['0']['sid']);
			if($result) exit('ok');
		}
		//减
		if($mmoo=='jj'){
			$data['num'] = array('exp','num-1');
			$result = M('dingdantem')->where($d)->save($data);
			if($result) exit('ok');
		}
	}
	//更新抢购数量
	function hhqqqgssnum($sid){
		$user=$this->jjccddll();
		$smyyy['id']=$sid;
		$yyzee=M('custom_reply_news')->where($smyyy)->limit(0,1)->select();
		if(!$yyzee['0']['qianggou']) return true;//没有开启抢购模式
		
		$data['qgnum'] = array('exp','qgnum-1');
		if($yyzee['0']['qgnum']<1) $data['qgnum']=0;
		$yyzee=M('custom_reply_news')->where($smyyy)->save($data);
		return true;//$yyzee['0']['qgnum'];
	}
	//更新产品数量
	function hhqqqgssnumccss($sid){
		$user=$this->jjccddll();
		$smyyy['id']=$sid;
		$yyzee=M('custom_reply_news')->where($smyyy)->limit(0,1)->select();
		//if(!$yyzee['0']['qianggou']) return true;//没有开启抢购模式
		
		$data['cpnum'] = array('exp','cpnum-1');
		if($yyzee['0']['cpnum']<1) $data['cpnum']=0;
		if(!$data['cpnum']) $data['shifsxj']=2;//更新下架
		$yyzee=M('custom_reply_news')->where($smyyy)->save($data);
		return true;//$yyzee['0']['cpnum'];
	}
	
	//抢购时间到
	function qiangogushijdaodao(){
		$user=$this->jjccddll();
		//删除临时订单商品
		$d['uid']=$user['id'];
		$d['id']=I ( 'id', 0, 'intval' );
				//获取抢购id
				$qgidmmmmm=M('dingdantem')->where($d)->limit(0,1)->select();
		//dump($qgidmmmmm);exit;
		if(!$qgidmmmmm['0']['sid']){
			return false;exit;
		}
		$result = M('dingdantem')->where($d)->delete();
			//更新产品数量
			//$user=$this->jjccddll();

				//$this->hhqqqgssnum($qgidmmmmm['0']['sid']);
				//$this->hhqqqgssnumccss($qgidmmmmm['0']['sid']);
			

			$smyyy['id']=$qgidmmmmm['0']['sid'];
			//$yyzee=M('custom_reply_news')->where($smyyy)->limit(0,1)->select();
			//if(!$yyzee['0']['qianggou']) return true;//没有开启抢购模式
			
			$data['qgnum'] = array('exp','qgnum+'.$qgidmmmmm['0']['num']);
			$data['cpnum'] = array('exp','cpnum+'.$qgidmmmmm['0']['num']);
			//if($yyzee['0']['cpnum']<1) $data['cpnum']=0;
			//if(!$data['cpnum']) $data['shifsxj']=2;//更新下架
			$yyzee=M('custom_reply_news')->where($smyyy)->save($data);
			return true;//$yyzee['0']['cpnum'];
	}
	
	
	
	//加入购物车
	function JoinCart(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/shooppcaa.html';
		$user=$this->jjccddll();
		
		$fuqshifoufanwang=$this->huoquxianjieudanzhifurenshu();
		if($fuqshifoufanwang) exit('Server busy..');

		
		$id=$user['id'];
		$tel=$user['tel'];
		if(!$id) exit('noloing');//未登录
		$sid=I ( 'sid', 0, 'intval' );//商品id
		$pic=I ( 'pic', 0, 'intval' );
		$chicun=I ( 'chicun', 0, 'strip_tags' );
		$ssfffjjjggg=I ( 'ssfffjjjggg', 0, 'intval' );
		$jiage=I ( 'jiage', 0, 'strip_tags' );
		$title=I ( 'title', 0, 'strip_tags' );
		if(!$sid || !$chicun) exit('exoo');
			//验证价格和尺寸
			//$smyyy['chicun']=array('like','\'%'.$chicun.'寸#'.$jiage.'%\'');
			$smyyy['id']=$sid;
			$yyzee=M('custom_reply_news')->where($smyyy)->limit(0,1)->select();
			
				$newcpnumnum=$yyzee['0']['cpnum'];//数量
				if($yyzee['0']['qianggou']){
					$newcpnumnum=$yyzee['0']['qgnum'];
				}
				if($newcpnumnum<1) exit('nonumxxoo');
				
				//验证是否抢购
				if($yyzee['0']['qianggou']){
					//抢购数量
					//$nnyyeessnum=$yyzee['0']['qgnum']-1;
					//if($nnyyeessnum<0) $nnyyeessnum=0;
					//$_SESSION['nnyyeessnum']=$nnyyeessnum;
					
					
					if(($yyzee['0']['qgstime']>(time()+30)) || ($yyzee['0']['qgetime']<(time()-30))){
						//30秒安全时间
						//非法抢购
						exit('fxoo');
					}
					if(!$yyzee['0']['qgnum']) exit('nxoo');
					
					$cjzssddggzzggmmqqgg=($this->config);
					$cjzssddggzzggmmqqgg=$cjzssddggzzggmmqqgg['cjzssddggzzggmmqqgg']+0;
					
					$data['qtime']=time()+($cjzssddggzzggmmqqgg*60);
					$this->hhqqqgssnum($yyzee['0']['id']);
				}
				$this->hhqqqgssnumccss($yyzee['0']['id']);
			
			$yychicun=$yyzee['0']['chicun'];
			$yychicun=explode("\r\n",$yychicun);
			//dump(str_ireplace(' ','',$chicun.'#'.$jiage));
			//dump($yychicun);
			foreach ($yychicun as &$v) {
				$v = str_ireplace(' ','',$v);
			}
			//dump($yychicun);
			$chicun=str_ireplace('2500152288','+',$chicun);
			if(!in_array(str_ireplace(' ','',$chicun.'#'.$jiage),$yychicun)) exit('ex0oo');
		/*
		if($sid){
			//获取商品
			$sm['id']=$sid;
			$s_tel=M('huiyuan')->where($sm)->limit(0,1)->select();
		}
		*/
		
		$data['tel']=$tel;
		$data['chicun']=$chicun;
		//判断购物车是否已经有了
		$sm['sid']=$sid;
		$sm['chicun']=$chicun;
		$sm['uid']=$id;
		$sm['ok']=0;
		$sm['jiage'] = array('neq','0');
		$s_tel=M('dingdantem')->where($sm)->limit(0,1)->select();
		if($s_tel && !$ssfffjjjggg){
			//echo 'fdasfads';
			$smdata['num']=$s_tel['0']['num']+1;
			$sms['id']=$s_tel['0']['id'];
			//dump($sms);
			$s_tel_s=M('dingdantem')->where($sms)->save($smdata);
			
			if($s_tel_s) exit('ok');
		}
		else{
			//写入购物车
			$data['sid']=$sid;
			$data['uid']=$id;
			$data['pic']=$pic;
			$data['jiage']=$jiage;
			$data['title']=$title;
			$data['ctime']=time();
			//$data['qtime']=$smdata['qtime'];
			$res = M('dingdantem')->add($data);
			$_SESSION['lijigoumaishangpinid']=$res;
			if($res) exit('ok');
			else exit('eoo');
		}
	}
	//厨师
	function chushi(){
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		if($user['quanxian']!=1){
			echo 'no!';
			exit;
		}
		$this->assign ( 'user', $user );
		//dump($user);
		
		$mmoo=I('get.mmoo','','strip_tags');
		$moid=I('get.id','','intval');
		
		//取消订单
		if($mmoo=='qx' && $moid){
			$qw['id']=$moid;
			$qd['qrdd']=3;
			M('dingdan')->where($qw)->save($qd);
			exit('ok');
			return true;
		}
		
		//确认订单
		if($mmoo=='qr' && $moid){
			$qw['id']=$moid;
			$qd['qrdd']=2;
			M('dingdan')->where($qw)->save($qd);
			exit('ok');
			return true;
		}
		//确认发货
		if($mmoo=='fh' && $moid){
			$qw['id']=$moid;
			$qd['zhuantai']=1;
			M('dingdan')->where($qw)->save($qd);
			exit('ok');
			return true;
		}
		//获取订单
		$order=('id desc');
		if(!$mmoo) {
			$dw['zhuantai']=0;
			$dw['qrdd']=array('neq',3);
			$order=('id asc');
		}
		if($mmoo=='yjqr') $dw['qrdd']=2;
		if($mmoo=='wcfh') $dw['zhuantai']=1;
		if($mmoo=='quxiao') $dw['qrdd']=3;
		$ds=M('dingdan')->where($dw)->order($order)->limit(0,999)->select();
		$this->assign ( 'ds', $ds );
		$this->assign ( 'mmoo', $mmoo );
		//dump($ds);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/chushi.html' );
	}
	
	
	//会员中心
	function MemberHome(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		//echo $this->getip();
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		//$this->assign ( 'user', $user );
		//会员首页
		//我的全部订单数量
		$mydd['uid']=$user['id'];
		$mys=M('dingdan')->where($mydd)->select();
		$mys_num=count($mys);
		$this->assign ( 'mys_num', $mys_num );
		//待付款订单数量
		foreach($mys as $k=>$v){
			if(!$v['fuk']) $mys_dfk_num++;
		}
		$this->assign ( 'mys_dfk_num', $mys_dfk_num+0 );
		//我的优惠券数量
		$mapcssh['uid']=$user['id'];
		$mapcssh['ok']=0;
		$mapcssh['etime']=array('gt',time());
		$dzsyh=M('huiyouhuiq')->where($mapcssh)->order('id desc')->select();
		//dump($dzsyh);exit;
		$this->assign ( 'dzsyhde_num', count($dzsyh) );
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/MemberHome.html' );
	}
	//我的优惠券
	function MyCoupons(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		
		$mapcssssyyy['id']=$user['id'];
		$s_telssss=M('huiyuan')->where($mapcssssyyy)->limit(0,1)->select();
		$s_telssss_sfyhh=$s_telssss['0']['mflqyhq'];
		$this->assign ( 's_telssss_sfyhh', $s_telssss_sfyhh );
		
		//获取我的优惠券
		$yhq['uid']=$user['id'];
		$yhq['ok']=0;
		$yhq['etime']=array('gt',time());
		$y=M('huiyouhuiq')->where($yhq)->order('ok asc,etime desc,id desc')->select();
		$this->assign ( 'y', $y);
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/MyCoupons.html' );
	}

	function MyCouponsNew(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		//获取我的优惠券
		$yhq['uid']=$user['id'];
		$yhq['ok']=0;
		$yhq['etime']=array('gt',time());
		//$yhq['jine']=array('gt',$_SESSION['new_Total_fee']);
		$y=M('huiyouhuiq')->where($yhq)->order('ok asc,etime desc,id desc')->select();
		$this->assign ( 'y', $y);
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/MyCouponsNew.html' );
	}
	//点击使用优惠券
	function MyCouponsNewUsy(){
		
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/SubmitOrder.html';
		$useid=I('get.useid','','intval');
		$_SESSION['gm_yhq_id']=$useid;
		$_SESSION['MyCouponsNewUsy']=1;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		
		header('Location:'.$_SESSION['dangqian_url']);exit;
		//获取我的优惠券
		//$yhq['uid']=$user['id'];
		//$yhq['ok']=0;
		//$y=M('huiyouhuiq')->where($yhq)->order('ok asc,etime desc,id desc')->select();
		//$this->assign ( 'y', $y);
		
		//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/MyCouponsNew.html' );
	}
	
	
	//抽奖记录
	function DrawRecord(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$_SESSION['jiangpianduihwdccid']=0;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		
		//过期
		$tongzhiggnryxqccjjj=($this->config);
		$tongzhiggnryxqccjjj=$tongzhiggnryxqccjjj['tongzhiggnryxqccjjj'];
		$this->assign ( 'tongzhiggnryxqccjjj', $tongzhiggnryxqccjjj );
		$tongzhiggnryxqccjjj=strtotime($tongzhiggnryxqccjjj);
		if(time()>$tongzhiggnryxqccjjj) $this->choujiangguoqi();
		
		
		$hhcjdata['id']=$user['id'];
		$hhccjj=M('huiyuan')->where($hhcjdata)->limit(0,1)->select();
					
		//获取今天的时间
		$n_data=date('Ymd');
		//会员今天登录时间
		$h_data=$hhccjj['0']['dtime'];
		//会员今天是否已经抽奖 dcjsf
		$h_dcjsf=$hhccjj['0']['dcjsf'];
		//echo $h_dcjsf;exit;
		//会员剩余抽奖次数
		$h_zcj=$hhccjj['0']['zcj']+$hhccjj['0']['dcjsf'];
		$this->assign ( 'sy', $h_zcj);
		
		//获取会员抽奖记录
		$mapc['uid']=$user['id'];
		$mapc['type']=1;
		$mapc['duij']=0;
		
		$ssfffyiij=I ( 'get.ssfffyiij', 0, 'strip_tags' );
		if($ssfffyiij==='ok'){
			//已经兑奖
			$mapc['duij']=1;
		}
		$this->assign ( 'ssfffyiij', $ssfffyiij);
		$s_tel=M('cjjll')->where($mapc)->order('id desc')->select();
		//dump($s_tel);exit;
		$this->assign ( 'c', $s_tel);
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/DrawRecord.html' );
	}
	//抽奖过期
	function choujiangguoqi(){
		$tongzhiggnryxqccjjj=($this->config);
		$tongzhiggnryxqccjjj=$tongzhiggnryxqccjjj['tongzhiggnryxqccjjj'];
		$tongzhiggnryxqccjjj=strtotime($tongzhiggnryxqccjjj);
		$d['guoqi']=$tongzhiggnryxqccjjj;
		$w['ctime']=array('LT',$tongzhiggnryxqccjjj);
		$w['guoqi']=array('EQ',0);
		if(time()>$tongzhiggnryxqccjjj) $s_tel=M('cjjll')->where($w)->save($d);
	}
	//我的订单
	function Myorder(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		//全部订单
		$mydd['uid']=$user['id'];
		//待付款 
		$dfk=I ( 'get.dfk', 0, 'strip_tags' );
		
		$this->assign ( 'dfk', $dfk );
		if($dfk==='dfk') $mydd['fuk']=array('eq','0');
		if($dfk==='yfk') $mydd['fuk']='已付款';
		if($dfk==='dsh') {
			$mydd['fuk']=array('neq','0');//$mydd['fuk']='已付款';
			$mydd['qrdd']=array('eq','2');
			$mydd['queren']=array('eq','0');
		}
		if($dfk==='dfkok') $mydd['queren']=1;
		
		$mys=M('dingdan')->where($mydd)->order('queren asc,id desc')->limit(0,9)->select();
		$this->assign ( 'mys', $mys );
		//取消订单
		$quxiao=I ( 'quxiao', 0, 'intval' );
		if($quxiao){
			$qw['id']=$quxiao;
			$qw['uid']=$user['id'];
			$myq=M('dingdan')->where($qw)->delete();
		}
		//确认收货
		$quren=I ( 'quren', 0, 'intval' );
		//echo $quren;exit;
		if($quren){
			$qw['id']=$quren;
			$qw['uid']=$user['id'];
			$qd['queren']=1;
			$myq=M('dingdan')->where($qw)->save($qd);
			//dump($qw);exit;
		}
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/Myorder.html' );
	}
	
	
	//我的订单
	function Myorderajax(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		//全部订单
		$mydd['uid']=$user['id'];
		//待付款 
		$dfk=I ( 'get.dfk', 0, 'strip_tags' );
		
		$this->assign ( 'dfk', $dfk );
		if($dfk==='dfk') $mydd['fuk']=array('eq','0');
		if($dfk==='dsh') {
			$mydd['fuk']='已付款';//array('neq','0');
			$mydd['queren']=array('eq','0');
		}
		if($dfk==='dfkok') $mydd['queren']=1;
		$ajajjaaxx=I('get.ajajjaaxx',0,'intval');
		$ajajjaaxx=$ajajjaaxx*9;
		$mys=M('dingdan')->where($mydd)->order('queren asc,id desc')->limit($ajajjaaxx,9)->select();
		//if(empty($mys)) exit('');
		$this->assign ( 'mys', $mys );
		//取消订单
		$quxiao=I ( 'quxiao', 0, 'intval' );
		if($quxiao){
			$qw['id']=$quxiao;
			$qw['uid']=$user['id'];
			$myq=M('dingdan')->where($qw)->delete();
		}
		//确认收货
		$quren=I ( 'quren', 0, 'intval' );
		//echo $quren;exit;
		if($quren){
			$qw['id']=$quren;
			$qw['uid']=$user['id'];
			$qd['queren']=1;
			$myq=M('dingdan')->where($qw)->save($qd);
			//dump($qw);exit;
		}
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/Myorderajax.html' );
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//我的余额
	function MyAccount(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		
		//2016.09.08
			//判断是否VIP
			$chongzhihuiyuan=$this->config;
			$_SESSION['chongzhihuiyuanpanshifhy']=$chongzhihuiyuan['chongzhihuiyuan'];
			//充值送金额
			$nnpnresszs=($this->config);
			$nnpnxxeezs=$nnpnresszs['chongzhisongjine'];
			
			$nnpnxxeezs=str_ireplace("\r\n",'#',$nnpnxxeezs);
			$nnpnxxeezs=str_ireplace("充",'',$nnpnxxeezs);
			
			$_SESSION['chonxxeennpnzzssnshifhy']=$nnpnxxeezs;
			
			

			//$_SESSION['chonxxeennpnzzssnshifhy']=$xxeennpnzzss;
		//end
		
		
		
		
		
		//获取余额
		$mapc['uid']=$user['id'];
		$s=M('recharge')->where($mapc)->limit(0,1)->select();
		
		//2016.09.08
			if(!$s['0']['id']){//没有会员余额，新建会员余额表
				$dataa['uid']=$user['id'];
				$dataa['tel']=$user['tel'];
				$dataa['yue']=0;
				$dataa['ctime']=time();
				$aaasss=M('recharge')->add($dataa);
			}
		//end
		
		
		
		$_SESSION['new_Total_fee_yue']=$s['0']['yue'];
		$this->assign ( 's', $s['0']);
		//获取充值记录
		$mapcjl['uid']=$user['id'];
		$mapcjl['leixin']=1;
		$sjl=M('finance')->where($mapcjl)->order('id desc')->select();
		$this->assign ( 'sjl', $sjl);
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/MyAccount.html' );
	}
	/*
	function generate_randsssss($l){
	  $c= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	  srand((double)microtime()*1000000);
	  for($i=0; $i<$l; $i++) {
		  $rand.= $c[rand()%strlen($c)];
	  }
	  return $rand;
	}*/
	function tteesss(){
		//echo $_SESSION['anquanmsalt']=$this->generate_randsssss(29);
	}
	//充值余额
	function chongzhi(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html';
		$user=$this->jjccddll();
		$_SESSION['user_id']=$user['id'];
		$_SESSION['user_tel']=$user['tel'];
		//微信支付失败返回链接
		$_SESSION['dangqian_url_weixinzhifushibai']='/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html';
		$jiner=$_POST['jiner']+0;
		if($jiner){
			$_SESSION['chongzhi_mod']=1;//类型充值1 购买2
			$_SESSION['anquanmsalt']=rand(100000,999999);//$this->generate_randsssss(9);
			//2016.09.08
			$_SESSION['new_Total_fee']=$jiner*100;
			header('Location:/zf.html');exit;
		}
		//充值成功，更新写入会员余额
		$chongzhiok=I ( 'get.chongzhiok', 0, 'strip_tags' );
		//exit;
		if($chongzhiok==='ok'){
			//检验
			$jjyyy['anquanmsalt']=$_SESSION['anquanmsalt'];
			$jjyyy['tel']=$user['tel'];
			$jjyyy['uid']=$user['id'];
			$jjyymmm=M('finance')->where($jjyyy)->find();
			if(!$jjyymmm || !$_SESSION['anquanmsalt']){
				$_SESSION['anquanmsalt']=0;
				//dump($_SESSION);
				//2016.09.08
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html');exit;
			}
			//dump($jjyymmm);exit;
			
			
			
			
			$cmapc['uid']=$user['id'];
			$cmapc['ok']=1;
				/*
				//购买商品
				$cmapc['leixin']=2;//类型2跳转到购买成功页面
				$c=M('finance')->where($cmapc)->limit(0,1)->select();
				$new_yue=$c['0']['jine'];
				if($new_yue){
					//修改订单为已付款
					$ddssfk['']
					
				}
				*/
			$cmapc['leixin']=1;//类型2跳转到购买成功页面
			$c=M('finance')->where($cmapc)->limit(0,1)->select();
			$new_yue=$c['0']['jine'];
			
			//判断是否VIP
			$chongzhihuiyuan=$this->config;
			$chongzhihuiyuan=$chongzhihuiyuan['chongzhihuiyuan'];
			if($new_yue>=$chongzhihuiyuan){
				$svip['id']=$user['id'];
				$dvip['vip']=1;
				$sdvip=M('huiyuan')->where($svip)->save($dvip);
			}
			//充值送金额
			$nnpnresszs=($this->config);
			$nnpnxxeezs=$nnpnresszs['chongzhisongjine'];
			$nnpnxxeezs=str_ireplace("\r\n",'#',$nnpnxxeezs);
			$nnpnxxeezs=str_ireplace("充",'',$nnpnxxeezs);
			$nnpnxxeezs=explode("#",$nnpnxxeezs);
			foreach ($nnpnxxeezs as &$vsfsdzs) {
				$vsfsdzs = str_ireplace(' ','',$vsfsdzs);
			}
			foreach($nnpnxxeezs as $kss=>$vsdfzs){
				if(!($kss%2)){
					if($nnpnxxeezs[($kss)]<=$new_yue){
						$xxeennpnzzss=$nnpnxxeezs[($kss+1)];//赠送金额
					}
				}
			}
			
			
			
			
			if($new_yue){
				//获取最新余额
					if($c){
						//更新财报
						$mcc['uid']=$user['id'];
						$mcc['leixin']=1;
						$mcc['id']=$jjyymmm['id'];
						$dcc['ok']=1;
						$dcc['zsyue']=$xxeennpnzzss;
						$ccbb=M('finance')->where($mcc)->save($dcc);
						$ccbb=M('finance_copy')->where($mcc)->save($dcc);
					}
			
				$mapcss['uid']=$user['id'];
				$sss=M('recharge')->where($mapcss)->limit(0,1)->select();
				$new_yue=$new_yue+$sss['0']['yue'];
				if(!$sss['0']['id']){//没有会员余额，新建会员余额表
					$dataa['uid']=$user['id'];
					$dataa['tel']=$user['tel'];
					$dataa['yue']=$xxeennpnzzss+0;
					$dataa['ctime']=time();
					$aaasss=M('recharge')->add($dataa);
					if($aaasss){					
						$mapcssaass['uid']=$user['id'];
						$dataaass['yue']=$new_yue;
						$sssaddss=M('recharge')->where($mapcssaass)->save($dataaass);
						/*if($sssaddss){
							//更新财报
							$mcc['uid']=$user['id'];
							$mcc['leixin']=1;
							$mcc['ok']=1;
							$dcc['ok']=0;
							$ccbb=M('finance')->where($mcc)->save($dcc);
							if($ccbb) header('Location:/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html');
						}*/
						if($sssaddss) {
							header('Location:/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html');exit;
						}
						
					}
				}
				else{
					//更新余额
					$mapcssaa['uid']=$user['id'];
					$dataaa['yue']=$new_yue+$xxeennpnzzss;
					$dataa['ctime']=time();
					$sssadd=M('recharge')->where($mapcssaa)->save($dataaa);
					if($sssadd) {
						header('Location:/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html');exit;
					}
						
				}
			}
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/MyAccount.html');exit;
		}
		
		
		
		$this->assign ( 'user', $user );
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/chongzhi.html' );
	}
	//账号信息
	function Accountinformation(){
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		//获取收获地址
		$mapc['uid']=$user['id'];
		$s_tel=M('shouhuodizi')->where($mapc)->order('mor desc,id desc')->select();
		$this->assign ( 's', $s_tel );
		
		//删除地址
		$mordel=I ( 'mordel', 0, 'intval' );
		if($mordel){
			$mapcsd['uid']=$user['id'];
			$mapcsd['id']=$mordel;
			$result = M('shouhuodizi')->where($mapcsd)->delete();
			if($result) {
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/Accountinformation.html');exit;
			}
		}
		
		//修改默认地址
		$mor=I ( 'mor', 0, 'intval' );
		if($mor){
			$mapcs['uid']=$user['id'];
			$datasd['mor']=0;
			$s_teld=M('shouhuodizi')->where($mapcs)->save($datasd);
			$mapcs['id']=$mor;
			$datas['mor']=1;
			if($s_teld) $s_telss=M('shouhuodizi')->where($mapcs)->save($datas);
			if($s_telss) {
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/Accountinformation.html');exit;
			}
		}
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/Accountinformation.html' );
	}
	//收获地址
	function shouhuodizi(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/Accountinformation.html';
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		if($_POST){
			//是否第一次添加地址
			$dicff['uid']=$user['id'];
			$dsss=M('shouhuodizi')->where($dicff)->find();
			if(!$dsss) $data['mor']=1;
			$data['uid']=$user['id'];
			$data['tel']=I ( 'tel', 0, 'strip_tags' );
			
			$data['fanwei']=I ( 'fanwei', 0, 'strip_tags' );
			$data['lat']=I ( 'lat', 0, 'strip_tags' );
			$data['lng']=I ( 'lng', 0, 'strip_tags' );
			
			$data['dz']=I ( 'dz', 0, 'strip_tags' );
			$data['xingm']=I ( 'xingm', 0, 'strip_tags' );
			$res = M('shouhuodizi')->add($data);
			if($res) {
				header('Location:'.$_SESSION['dangqian_url']);exit;
			}
			//header('Location:/index.php?s=/addon/WeiSite/WeiSite/Accountinformation.html');
		}
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/shouhuodizi.html' );
	}
	function shouhuodizidiliwe(){
			$user=$this->jjccddll();
		if($_POST){
			//是否第一次添加地址
			$dicff['uid']=$user['id'];
			$dsss=M('shouhuodizi')->where($dicff)->find();
			if(!$dsss) $data['mor']=1;
			$data['uid']=$user['id'];
			$data['tel']=I ( 'tel', 0, 'strip_tags' );
			
			$data['fanwei']=I ( 'fanwei', 0, 'strip_tags' );
			$data['lat']=I ( 'lat', 0, 'strip_tags' );
			$data['lng']=I ( 'lng', 0, 'strip_tags' );
			
			$data['dz']=I ( 'dz', 0, 'strip_tags' );
			$data['xingm']=I ( 'xingm', 0, 'strip_tags' );
			$res = M('shouhuodizi')->add($data);
			if($res) {
				header('Location:'.$_SESSION['dangqian_url']);exit;
			}
			//header('Location:/index.php?s=/addon/WeiSite/WeiSite/Accountinformation.html');
		}
		//header('Location:/index.php?s=/addon/WeiSite/WeiSite/index.html');
	}
	function baidumappost(){
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		$this->assign ( 'posts', $_POST );
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/baidumappost.html' );
	}
	
	
	function shouhuodizinew(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/SubmitOrder.html';
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		if($_POST){
			//是否第一次添加地址
			$dicff['uid']=$user['id'];
			$dsss=M('shouhuodizi')->where($dicff)->find();
			if(!$dsss) $data['mor']=1;
			$data['uid']=$user['id'];
			$data['tel']=I ( 'tel', 0, 'strip_tags' );
			
			$data['lat']=I ( 'lat', 0, 'strip_tags' );
			$data['lng']=I ( 'lng', 0, 'strip_tags' );
			
			$data['dz']=I ( 'dz', 0, 'strip_tags' );
			$data['xingm']=I ( 'xingm', 0, 'strip_tags' );
			$res = M('shouhuodizi')->add($data);
			if($res) {
				header('Location:'.$_SESSION['dangqian_url']);exit;
			}
			//header('Location:/index.php?s=/addon/WeiSite/WeiSite/Accountinformation.html');
		}
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/shouhuodizinew.html' );
	}
	
	//修改密码
	function xiugaimim(){
		//设置要跳转链接
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/MemberHome.html';
		//$_SESSION['dangqian_url']=__SELF__;
		$user=$this->jjccddll();
		$this->assign ( 'user', $user );
		$codeddd=I ( 'codeddd', 0, 'intval' );
		$ajaxsss=I ( 'ajaxsss', 0, 'strip_tags' );
		if($ajaxsss==='ok'){
			if($codeddd!=$_SESSION['check_pic']){
				exit('eoo');
			}
			else exit('ok');
		}
		if($_POST){
			
				$new_salt=$this->generate_rand(9);
				$mapcs['tel']=$user['tel'];
				$mapcs['id']=$user['id'];
				$data['salt']=$new_salt;
				$data['pass']=md5($_POST['password'].$new_salt);
				$data['lip']=0;
				$data['mTime']=0;
				$data['saltr']=0;
				$s_tel_s=M('huiyuan')->where($mapcs)->save($data);
				if($s_tel_s) {
					session_destroy();
					$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/MemberHome.html';
					header('Location:/index.php?s=/addon/WeiSite/WeiSite/login.html');
				}
				else exit('xoo');
				exit;

		}
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/ColorV1/xiugaimim.html' );
	}
	//上传头像
	function uptx(){
		$user=$this->jjccddll();
		$this->assign('user', $user);
		if($_FILES["files"]["tmp_name"]){
			move_uploaded_file($_FILES["files"]["tmp_name"],"tx/" . $user['id'].'.jpg');
			//echo "文件已经被存储到: " . "tx/" . $_FILES["files"]["name"];
			echo '<script>location.href = \'/index.php?s=/addon/WeiSite/WeiSite/MemberHome/\';</script>';
		}
		$this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/tx.html');
	}
	//新上传头像
	function uptxnew(){
		$user=$this->jjccddll();
		$this->assign('user', $user);
		$this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/uptxnew.html');
	}
	
	
	
	//退出
	function tuichu(){
		//if(!$_SESSION['dangqian_url']) 
			session_destroy();
		$_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/index.html';
		setcookie("tel", 0, time()-3600000);
		setcookie("logg", 0, time()-3600000);
		//$_SESSION=array();
		$_SESSION['gm_yhq_id']=0;
		$_SESSION['new_Total_fee']=0;
		$this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/loginout.html');
		
		//header('Location:/index.php?s=/addon/WeiSite/WeiSite/index.html');
	}
	//检查登录状态
	function jjccddll(){

		$id=$_COOKIE["tel"]+0;
		$logg=$_COOKIE["logg"];
		if(!$id || !$logg) {
			header('Location:/index.php?s=/addon/WeiSite/WeiSite/login.html');
			exit;
		}
		if($id && $logg){
			$mapc['id']=$id;
			$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
			
			
					//获取今天的时间
					$n_data=date('Ymd');
					//会员今天登录时间
					$h_data=$s_tel['0']['dtime'];
					//会员今天是否已经抽奖 dcjsf
					if($h_data!=$n_data){//会员今天第一次登录
						$data['dtime']=$n_data;
						
						
						$nnpncjzssdd=($this->config);
						$nnpncjzssdd=$nnpncjzssdd['cjzssdd']+0;
						
						
						$data['dcjsf']=$nnpncjzssdd;
						
						
						
						$data['mflqyhq']=1;
						$w['id']=$s_tel['0']['id'];
						$ddm=M('huiyuan')->where($w)->save($data);
					}
			
			
			$s_logg=($s_tel['0']['logg']);
			$s_saltr=($s_tel['0']['saltr']);
			$s_mTime=($s_tel['0']['mTime']);
			$s_rip=$this->getip();
			
			$s_new_logg=md5($s_rip.$s_saltr);//md5($s_rip.$s_mTime.$s_saltr);
			
			if($s_new_logg!=$s_logg || $logg!=$s_logg || !$s_tel['0']['tel']) {
				header('Location:/index.php?s=/addon/WeiSite/WeiSite/login.html');exit;
			}
			
			$newuser=array();
			//$newuser['id']=$id;
			//$newuser['tel']=$s_tel['0']['tel'];
			//$newuser['tel']=$s_tel['0']['tel'];
			$newuser=$s_tel['0'];
			return $newuser;
		}
	}
	//获取ip
		function getIP(){
			return '2500152288';
			/*
			if (getenv('HTTP_CLIENT_IP')) { 
			$ip = getenv('HTTP_CLIENT_IP'); 
			} 
			elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
			$ip = getenv('HTTP_X_FORWARDED_FOR'); 
			} 
			elseif (getenv('HTTP_X_FORWARDED')) { 
			$ip = getenv('HTTP_X_FORWARDED'); 
			} 
			elseif (getenv('HTTP_FORWARDED_FOR')) { 
			$ip = getenv('HTTP_FORWARDED_FOR'); 

			} 
			elseif (getenv('HTTP_FORWARDED')) { 
			$ip = getenv('HTTP_FORWARDED'); 
			} 
			else { 
			$ip = $_SERVER['REMOTE_ADDR']; 
			} 
			return sprintf("%u",ip2long($ip)); */
		} 
	
	//随机盐
	function generate_rand($l){
	  $c= "ABCDEFGHJKLMNPQRSTUVWXYabcdefghijkmnpqrstuvwxy3456789";
	  srand((double)microtime()*1000000);
	  for($i=0; $i<$l; $i++) {
		  $rand.= $c[rand()%strlen($c)];
	  }
	  return $rand;
	}
	//注册
	function register(){
		//设置要跳转链接
		if(!$_SESSION['dangqian_url']) $_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/MemberHome.html';
		//dump($_POST);
		//验证发送手机验证码
		$codeddd=I ( 'codeddd', 0, 'intval' );
		$tel=I ( 'tel', 0, 'strip_tags' )+0;
		if(!$tel) $tel=$_POST['tel'];
		if(strlen($tel)!=11) $tel=0;
		$mapc['tel']=$tel;

		if($codeddd && $tel){
		
				$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
				$s_tel=($s_tel['0']['id']);
				if($s_tel) exit('hoo');
			if($codeddd==$_SESSION['check_pic']){
				//手机短信验证码
				$_SESSION['check_mobile']=$tel;
				$_SESSION['check_code']=rand(100000,999999);
				//$_SESSION['check_codessss']=$_SESSION['check_code'];
				$_SESSION['check_text']='【艾娜西点】您的验证码是'.$_SESSION['check_code'];
				//sleep(1);
				exit('ok');
			}
			else exit('eoo');
		}
		//echo $_SESSION['check_code'];
		//判断手机验证码
		$telcodesss=I ( 'telcodesss', 0, 'intval' );
		if($telcodesss){
			//echo $_SESSION['check_code'];
			if($telcodesss!=$_SESSION['check_code']) exit('eoo');
			else exit('ok');
		}
							/*setcookie("tel", 0, time()-3600000);
							setcookie("logg", 0, time()-3600000);*/
		
		if($_POST && $_SESSION['check_code']==$_POST['telcode'] && $tel){
			//写入注册信息
			$data ['token'] = get_token ();
			$data['rip']=$this->getip();
			$data['tel']=$_SESSION['check_mobile'];//$_POST['tel'];
			$salt=$this->generate_rand(9);//rand(100000,999999);
			$data['salt']=$salt;
			$data['pass']=md5($_POST['password'].$salt);
			$data['cTime']=time();
			$data['mTime']=$data['cTime'];
			$saltr=$this->generate_rand(9);
			$data['saltr']=$saltr;
			$data['lip']=$data['rip'];
			$data['zcj']=0;//$_SESSION['guanzhu_choujiang'];
			$data['logg']=md5($data['rip'].$data['saltr']);//md5($data['rip'].$data['mTime'].$data['saltr']);
				//注册送抽奖次数
				$nnpn=($this->config);
				$nnpn=$nnpn['cjzss']+0;
				
				//$nnpncjzssdd=($this->config);
				//$nnpncjzssdd=$nnpncjzssdd['cjzssdd']+0;
				
				$data['dtime']=date('Ymd');
				
				if($nnpn) $data['zcj']=$_SESSION['guanzhu_choujiang']+$nnpn;//$_SESSION['guanzhu_choujiang']+$nnpn;
			
			$res = M('Huiyuan')->add($data);

			if($res) {
				setcookie("tel", $res, time()+3600000);
				setcookie("logg", $data['logg'], time()+3600000);
				
			//注册赠送代金券
			//$user=$this->jjccddll();
			$hyqqdata['uid']=$res;//$user['id'];
			$nnpnress=($this->config);
			$hyqqdata['jine']=$nnpnress['res_zssdjjed'];
			$nnpns=$nnpnress['zssdjjedyxq']*86400;
			$nnpns=$nnpns+time();
			$hyqqdata['etime']=$nnpns;
			//使用条件
			$nnpnxxee=$nnpnress['djqshiyongxianer'];
			$nnpnxxee=str_ireplace("\r\n",'#',$nnpnxxee);
			$nnpnxxee=str_ireplace("购",'',$nnpnxxee);
			$nnpnxxee=explode("#",$nnpnxxee);
			foreach ($nnpnxxee as &$v) {
				$v = str_ireplace(' ','',$v);
			}
			$xxeennpn=array_search($hyqqdata['jine'],$nnpnxxee);
			if($xxeennpn) $xxeennpn=$nnpnxxee[($xxeennpn-1)];
			
			$hyqqdata['xe']=$xxeennpn;
			if($hyqqdata['jine']) $hyqadd=M('huiyouhuiq')->add($hyqqdata);
				
				
				
				
				//写入中奖信息
				if($_SESSION['guanzhu_choujiang_one']) {
					$_SESSION['guanzhu_choujiang_tel']=$data['tel'];
					$_SESSION['guanzhu_choujiang_uid']=$res;
					$this->ssxxeccjjjxx();
				}
				//sleep(1);
				header('Location:'.$_SESSION['dangqian_url']);exit;
				//  /index.php?s=/addon/WeiSite/WeiSite/MemberHome.html');
			}
		}
		
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/register.html' );
	}
	//登录免费领取优惠券
	function mflqyhq(){
		$user=$this->jjccddll();
		$mapc['id']=$user['id'];
		$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
		if($s_tel['0']['mflqyhq']){
			//赠送优惠券
			$hyqqdata['uid']=$user['id'];//$user['id'];
			$nnpnress=($this->config);
			$hyqqdata['jine']=$nnpnress['zssdjjed'];
			$nnpns=$nnpnress['zssdjjedyxq']*86400;
			$nnpns=$nnpns+time();
			$hyqqdata['etime']=$nnpns;
			if($hyqqdata['jine']) $hyqadd=M('huiyouhuiq')->add($hyqqdata);
			$mmdsat['mflqyhq']=0;
			$s_tel=M('huiyuan')->where($mapc)->save($mmdsat);
		}
		header('Location:/index.php?s=/addon/WeiSite/WeiSite/MyCoupons.html');exit;
	}
	
	
	//忘记密码--验证手机和验证码
	function ForgetPassword(){
		$codeddd=I ( 'codeddd', 0, 'intval' );
		$tel=I ( 'tel', 0, 'strip_tags' )+0;
		if($codeddd && $tel){
				$mapc['tel']=$tel;
				$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
				$s_tel=($s_tel['0']['id']);
				if(!$s_tel) exit('hoo');
			if($codeddd!=$_SESSION['check_pic']){
				exit('eoo');
				/*
				//手机短信验证码
				$_SESSION['check_mobile']=$tel;
				$_SESSION['check_code']=rand(100000,999999);
				$_SESSION['check_codessss']=123456;//$_SESSION['check_code'];
				//sleep(1);
				exit('ok');
				*/
			}
			else{
				//生成新密码
				$new_pass=$this->generate_rand(9);
				$_SESSION['check_mobile']=$tel;
				$_SESSION['check_mobile_newpass']=$_SESSION['check_mobile'];
				$_SESSION['check_code_passss']=$new_pass;//$_SESSION['check_code'];
				$_SESSION['check_text']='【艾娜西点】您的新密码是'.$new_pass;
				exit('ok');
			}
		}
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/ForgetPassword.html' );
	}
	//忘记密码--修改密码
	function ForgetPasswordStwo(){
		if($_SESSION['check_code_passss'] && $_SESSION['check_mobile_newpass']){
				$new_salt=$this->generate_rand(9);
				$mapcs['tel']=$_SESSION['check_mobile_newpass'];
				$data['salt']=$new_salt;
				$data['pass']=md5($_SESSION['check_code_passss'].$new_salt);
				$data['lip']=0;
				$data['mTime']=0;
				$data['saltr']=0;
				$s_tel_s=M('huiyuan')->where($mapcs)->save($data);
				if($s_tel_s) header('Location:/index.php?s=/addon/WeiSite/WeiSite/login.html');
				else exit('xoo');
				exit;
		}
		else exit('eoo');
		//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/ForgetPasswordStwo.html' );
	}
	//取消登录抽奖机会
	function quxiaodlccjj(){
		$user=$this->jjccddll();
		$data['dcjsf']=0;
		$mapcs['id']=$user['id'];
		$s_tel_s=M('huiyuan')->where($mapcs)->save($data);
		header('Location:/index.php?s=/addon/WeiSite/WeiSite/MemberHome.html');exit;
	}
	
	//登录
		function login() {
			if(!$_SESSION['dangqian_url']) $_SESSION['dangqian_url']='/index.php?s=/addon/WeiSite/WeiSite/MemberHome.html';
							/*setcookie("tel", 0, time()-3600000);
							setcookie("logg", 0, time()-3600000);*/
			if($_POST && ($_POST['tel']+0)){
				$tel=$_POST['tel']+0;
				$code=$_POST['code'];
				$password=$_POST['password'];
					$mapc['tel']=$tel;
					$s_tel=M('huiyuan')->where($mapc)->limit(0,1)->select();
					
					//获取今天的时间
					$n_data=date('Ymd');
					//会员今天登录时间
					$h_data=$s_tel['0']['dtime'];
					//会员今天是否已经抽奖 dcjsf
					if($h_data!=$n_data){//会员今天第一次登录
						$data['dtime']=$n_data;
						
						$nnpncjzssdd=($this->config);
						$nnpncjzssdd=$nnpncjzssdd['cjzssdd']+0;
						$data['dcjsf']=$nnpncjzssdd;
						$data['mflqyhq']=1;
					}
					
					if($code!=$_SESSION['check_pic']) exit('eoo'); //注册码错误
					if(!$s_tel['0']['id']) exit('hoo');//手机号没有注册
					if(md5($password.$s_tel['0']['salt'])==$s_tel['0']['pass']) {
						//header('Location:/index.php?s=/addon/WeiSite/WeiSite/MemberHome.html');
						
						$data['lip']=$this->getip();
						$data['mTime']=time();
						$data['saltr']=$this->generate_rand(9);
						$logg=md5($data['lip'].$data['saltr']);//md5($data['lip'].$data['mTime'].$data['saltr']);
						$data['logg']=$logg;
						$mapcs['id']=$s_tel['0']['id'];
						$s_tel_s=M('huiyuan')->where($mapcs)->save($data);
							setcookie("tel", $mapcs['id'], time()+3600000);
							setcookie("logg", $logg, time()+3600000);
						if($data['dcjsf']) exit('cj');
						exit('ok');//登录成功
					}
					else exit('xoo'); //手机号或密码错误
			}
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/login.html' );
		}
	//搜索
	function souss(){
		//关键词
		$keyw=I ( 'keyw', 0, 'strip_tags' );
		if(!$keyw) exit;
		$this->assign ( 'loandcss', 'Products' );
		$this->assign('xltitle',$keyw.'-产品搜索-艾娜西点');
		$this->assign('keyword',$keyw.',产品搜索,艾娜西点');
		$this->assign('intro',$keyw.',产品搜索-艾娜西点');
		//购物车数量
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );

		//获取分类
		$mapfl['pid']=6;
		$infofl = M ( 'weisite_category' )->where ( $mapfl )->select ();
		//dump($infofl);
		foreach($infofl as $k=>$v){
			if(!$sssin) $sssin=$v['id'];
			else $sssin=$sssin.','.$v['id'];
			
		}
		//$this->assign('infofl',$infofl);
		//echo $sssin;
		//$maps['title'] = array('like',$keyw.'%');
		$s=M('custom_reply_news')->where('cate_id IN(\''.$sssin.'\') AND title like \'%'.$keyw.'%\'')->select();
		//dump($s);
		$this->assign ( 's', $s );
		
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/souss.html' );
	}
	// 首页
	function index() {
		//设置要跳转链接
		$_SESSION['dangqian_url']=__SELF__;
		add_credit ( 'weisite', 86400 );
		
		$ggwwnumber=$this->ssggwwnum();
		$this->assign ( 'ggwwnumber', $ggwwnumber );

		//过期
		$tongzhiggnryxqccjjj=($this->config);
		$tongzhiggnryxqccjjj=$tongzhiggnryxqccjjj['tongzhiggnryxqccjjj'];
		$this->assign ( 'tongzhiggnryxqccjjj', $tongzhiggnryxqccjjj );
		$tongzhiggnryxqccjjj=strtotime($tongzhiggnryxqccjjj);
		if(time()>$tongzhiggnryxqccjjj) $this->choujiangguoqi();
		

			$tongzhigonggao=($this->config);
			$tongzhiggnr=$tongzhigonggao['tongzhiggnr'];
			$this->assign ( 'tongzhiggnr', $tongzhiggnr );
			$this->assign ( 'tongzhiggnryxxms', $tongzhigonggao['tongzhiggnryxxms']*1000 );
			$this->assign ( 'tongzhiggnryxq', $tongzhigonggao['tongzhiggnryxq'] );
			
		$tongzhiggnryxxmsccdd=$tongzhigonggao['tongzhiggnryxxmsccdd'];
		
		$tongzhiggnryxqno=0;
		if(time()<strtotime($tongzhigonggao['tongzhiggnryxq']) && $tongzhiggnryxxmsccdd){
			$tongzhiggnryxqno=1;
		}
			$this->assign ( 'tongzhiggnryxqno', $tongzhiggnryxqno );
		
		
		
		
		
		
		
		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_index'] . '.html' )) {
			$this->pigcms_index ();
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_index'] . '.html' );
		} else {
			//$map ['token'] = get_token ();
			$map ['is_show'] = 1;
			$map ['pid'] = 0; // 获取一级分类

			// 幻灯片
			$slideshow = M ( 'weisite_slideshow' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
			foreach ( $slideshow as &$vo ) {
				$vo ['img'] = get_cover_url ( $vo ['img'] );
			}
			$this->assign ( 'slideshow', $slideshow );
			//dump($slideshow);

			//新品推荐
						//下架显示隐藏
						$mapc['xiajss']=array('NEQ',2);
			$nnpn=($this->config);
			$nnpn=$nnpn['xinpp'];
			$mapc['cate_id']=15;
			$s_tel=M('custom_reply_news')->where($mapc)->order ( 'sort asc, id desc' )->limit(0,$nnpn)->select();
			$this->assign ( 'tj', $s_tel );
			
			//dump($s_tel);
			// 分类
			$category = M ( 'weisite_category' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
			foreach ( $category as &$vo ) {
				$vo ['icon'] = get_cover_url ( $vo ['icon'] );
				empty ( $vo ['url'] ) && $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', array (
						'cate_id' => $vo ['id']
				) );
			}
			$this->assign ( 'category', $category );

			$map2 ['token'] = $map ['token'];
			$public_info = get_token_appinfo ( $map2 ['token'] );
			$this->assign ( 'publicid', $public_info ['id'] );

			$this->assign ( 'manager_id', $this->mid );


			$this->assign ( 'loandcss', 'index' );
			$this->assign('xltitle','首页-艾娜西点');


			$this->_footer ();

			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/index.html' );
		}
	}
	// 分类列表
	function lists($cate_id,$pn,$nnpn) {
		//$cate_id = I ( 'cate_id', 0, 'intval' );
		empty ( $cate_id ) && $cate_id = I ( 'classid', 0, 'intval' );

		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_lists'] . '.html' )) {
			$this->pigcms_lists ( $cate_id );
			//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_lists'] . '.html' );
		} else {
			$map ['token'] = get_token ();
			if ($cate_id) {
				$map ['cate_id'] = $cate_id;
			}
			$cate = M ( 'weisite_category' )->where ( 'id = ' . $map ['cate_id'] )->find ();
			//$this->assign ( 'cate', $cate );
			// 二级分类
			$category = M ( 'weisite_category' )->where ( 'pid = ' . $map ['cate_id'] )->order ( 'sort asc, id desc' )->select ();
			if (! empty ( $category )) {
				foreach ( $category as &$vo ) {
					$vo ['icon'] = get_cover_url ( $vo ['icon'] );
					empty ( $vo ['url'] ) && $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', array (
							'cate_id' => $vo ['id']
					) );
				}
				//$this->assign ( 'category', $category );
				$this->_footer ();
				//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateSubcate/' . $this->config ['template_subcate'] . '/index.html' );
			} else {
						//下架显示隐藏
						$map['xiajss']=array('NEQ',2);
				$page = I ( 'p', 1, 'intval' );
				$row = isset ( $_REQUEST ['list_row'] ) ? intval ( $_REQUEST ['list_row'] ) : 20;

				$data = M ( 'custom_reply_news' )->where ( $map )->order ( 'sort asc, id DESC' )->limit ( ($pn*$nnpn), $nnpn )->select ();
				/* 查询记录总数 */
				$count = M ( 'custom_reply_news' )->where ( $map )->count ();
				$list_data ['list_data'] = $data;
				// 分页
				if ($count > $row) {
					$page = new \Think\Page ( $count, $row );
					$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
					$list_data ['_page'] = $page->show ();
				}

				//$this->assign ( $list_data );
				// dump ( $list_data );
				return $list_data;
				//$this->_footer ();

				//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/'.$list.'.html' );
			}
		}
	}
	// 详情
	function detail($id) {
		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_detail'] . '.html' )) {
			$this->pigcms_detail ();
			//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_detail'] . '.html' );
		} else {
			$map ['id'] = $id;//I ( 'get.id', 0, 'intval' );
			$info = M ( 'custom_reply_news' )->where ( $map )->find ();
			//$this->assign ( 'info', $info );

			M ( 'custom_reply_news' )->where ( $map )->setInc ( 'view_count' );
			return $info;
			$this->_footer ();
			//$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateDetail/' . $this->config ['template_detail'] . '/detail.html' );
		}
	}

	// 3G页面底部导航
	function _footer($temp_type = 'weiphp') {
		if ($temp_type == 'pigcms') {
			$param ['token'] = $token = get_token ();
			$param ['temp'] = $this->config ['template_footer'];
			$url = U ( 'Home/Index/getFooterHtml', $param );
			$html = wp_file_get_contents ( $url );
			// dump ( $url );
			// dump ( $html );
			$file = RUNTIME_PATH . $token . '_' . $this->config ['template_footer'] . '.html';
			if (! file_exists ( $file ) || true) {
				file_put_contents ( $file, $html );
			}

			$this->assign ( 'cateMenuFileName', $file );
		} else {
			$list = D ( 'Addons://WeiSite/Footer' )->get_list ();

			foreach ( $list as $k => $vo ) {
				if ($vo ['pid'] != 0)
					continue;

				$one_arr [$vo ['id']] = $vo;
				unset ( $list [$k] );
			}

			foreach ( $one_arr as &$p ) {
				$two_arr = array ();
				foreach ( $list as $key => $l ) {
					if ($l ['pid'] != $p ['id'])
						continue;

					$two_arr [] = $l;
					unset ( $list [$key] );
				}

				$p ['child'] = $two_arr;
			}
			$this->assign ( 'footer', $one_arr );

			$html = $this->fetch ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateFooter/' . $this->config ['template_footer'] . '/footer.html' );
			$this->assign ( 'footer_html', $html );
		}
	}
	function _deal_footer_data($vo, $k) {
		$arr = array (
				'id' => $vo ['id'],
				'fid' => $vo ['pid'],
				'token' => $vo ['token'],
				'name' => $vo ['title'],
				'orderss' => 0,
				'picurl' => get_cover_url ( $vo ['icon'] ),
				'url' => $vo ['url'],
				'status' => "1",
				'RadioGroup1' => "0",
				'vo' => array (),
				'k' => $k
		);
		return $arr;
	}
	function coming_soom() {
		$this->display ();
	}
	function tvs1_video() {
		$this->display ();
	}

	/*
	 * 兼容小猪CMS模板
	 *
	 * 移植方法：
	 * 1、把 tpl\static\tpl 目录下的所有文档复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 2、把 tpl\Wap\default 目录下的所有文档也复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 3、把 tpl\User\default\common\ 目录下的所有图片文件复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 4、把 PigCms\Lib\ORG\index.Tpl.php 文件复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 5、把pigcms 目录下所有文档代码里的 Wap/Index/lists 替换成 Home/Addons/execute?_addons=WeiSite&_controller=WeiSite&_action=lists
	 * 6、把pigcms 目录下所有文档代码里的 Wap/Index/index 替换成 Home/Addons/execute?_addons=WeiSite&_controller=WeiSite&_action=index
	 */
	function pigcms_init() {
		// dump ( 'pigcms_init' );
		C ( 'TMPL_L_DELIM', '{pigcms:' );
		// C ( 'TMPL_FILE_DEPR', '_' );

		define ( 'RES', ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/common' );

		$public_info = get_token_appinfo ();
		$manager = get_userinfo ( $public_info ['uid'] );

		// 站点配置
		$data ['f_logo'] = get_cover_url ( C ( 'SYSTEM_LOGO' ) );
		$data ['f_siteName'] = C ( 'WEB_SITE_TITLE' );
		$data ['f_siteTitle'] = C ( 'WEB_SITE_TITLE' );
		$data ['f_metaKeyword'] = C ( 'WEB_SITE_KEYWORD' );
		$data ['f_metaDes'] = C ( 'WEB_SITE_DESCRIPTION' );
		$data ['f_siteUrl'] = SITE_URL;
		$data ['f_qq'] = '';
		$data ['f_qrcode'] = '';
		$data ['f_ipc'] = C ( 'WEB_SITE_ICP' );
		$data ['reg_validDays'] = 30;

		// 用户信息
		$data ['user'] = array (
				'id' => $GLOBALS ['myinfo'] ['uid'],
				'openid' => get_openid (),
				'username' => $GLOBALS ['myinfo'] ['nickname'],
				'mp' => $public_info ['token'],
				'password' => $GLOBALS ['myinfo'] ['password'],
				'email' => $GLOBALS ['myinfo'] ['email'],
				'createtime' => $GLOBALS ['myinfo'] ['reg_time'],
				'lasttime' => $GLOBALS ['myinfo'] ['last_login_time'],
				'status' => 1,
				'createip' => $GLOBALS ['myinfo'] ['reg_ip'],
				'lastip' => $GLOBALS ['myinfo'] ['last_login_ip'],
				'smscount' => 0,
				'inviter' => 1,
				'gid' => 5,
				'diynum' => 0,
				'activitynum' => 0,
				'card_num' => 0,
				'card_create_status' => 0,
				'money' => 0,
				'moneybalance' => 0,
				'spend' => 0,
				'viptime' => $GLOBALS ['myinfo'] ['last_login_time'] + 86400,
				'connectnum' => 0,
				'lastloginmonth' => 0,
				'attachmentsize' => 0,
				'wechat_card_num' => 0,
				'serviceUserNum' => 0,
				'invitecode' => '',
				'remark' => ''
		);

		// 微网站配置信息
		$data ['homeInfo'] = array (
				'id' => $manager ['uid'],
				'token' => $public_info ['token'],
				'title' => $this->config ['title'],
				'picurl' => get_cover_url ( $this->config ['cover'] ),
				// 'apiurl' => "",
				// 'homeurl' => "",
				'info' => $this->config ['info'],
				// 'musicurl' => "",
				// 'plugmenucolor' => "#5CFF8D",
				'copyright' => $manager ['copy_right'],
				// 'radiogroup' => "12",
				// 'advancetpl' => "0"
				'logo' => get_cover_url ( $this->config ['cover'] )
		);

		// 背景图
		$data ['flashbgcount'] = 1;
		$data ['flashbg'] [0] = array (
				'id' => $this->config ['background_id'],
				'token' => $public_info ['token'],
				'img' => $this->config ['background'],
				'url' => "javascript:void(0)",
				'info' => "背景图片",
				'tip' => '2'
		);
		$data ['flashbgcount'] = count ( $data ['flashbg'] );

		// 幻灯片
		$slideshow = M ( 'weisite_slideshow' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
		foreach ( $slideshow as $vo ) {
			$data ['flash'] [] = array (
					'id' => $vo ['id'],
					'token' => $vo ['token'],
					'img' => get_cover_url ( $vo ['img'] ),
					'url' => $vo ['url'],
					'info' => $vo ['title'],
					'tip' => '1'
			);
		}
		$data ['num'] = count ( $data ['flash'] );

		// 底部栏
		$this->_footer ( 'pigcms' );

		// 设置版权信息
		$data ["iscopyright"] = 0;
		$data ["copyright"] = $data ["siteCopyright"] = empty ( $manager ['copy_right'] ) ? C ( 'COPYRIGHT' ) : $manager ['copy_right'];
		// 分享
		$data ['shareScript'] = '';

		$data ['token'] = $public_info ['token'];
		$data ['wecha_id'] = $public_info ['wechat'];

		$this->assign ( $data );

		// 模板信息
		if (file_exists ( ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/index.Tpl.php' )) {
			$pigcms_temps = require_once ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/index.Tpl.php';
			foreach ( $pigcms_temps as $k => $vo ) {
				$temps [$vo ['tpltypename']] = $vo;
			}
		}

		if (file_exists ( ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/cont.Tpl.php' )) {
			$pigcms_temps = require_once ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/cont.Tpl.php';
			foreach ( $pigcms_temps as $k => $vo ) {
				$temps [$vo ['tpltypename']] = $vo;
			}
		}
		$tpl = array (
				'id' => $public_info ['id'],
				'routerid' => "",
				'uid' => $public_info ['uid'],
				'wxname' => $public_info ['public_name'],
				'winxintype' => $public_info ['type'],
				'appid' => $public_info ['appid'],
				'appsecret' => $public_info ['secret'],
				'wxid' => $public_info ['id'],
				'weixin' => $public_info ['wechat'],
				'headerpic' => get_cover_url ( $GLOBALS ['myinfo'] ['headface_url'] ),
				'token' => $public_info ['token'],
				'pigsecret' => $public_info ['token'],
				'province' => $GLOBALS ['myinfo'] ['province'],
				'city' => $GLOBALS ['myinfo'] ['city'],
				'qq' => $GLOBALS ['myinfo'] ['qq'],
				// 'wxfans' => "0",
				// 'typeid' => "8",
				// 'typename' => "服务",
				// 'tongji' => "",
				// 'allcardnum' => "0",
				// 'cardisok' => "0",
				// 'yetcardnum' => "0",
				// 'totalcardnum' => "0",
				// 'createtime' => "1440150418",
				// 'updatetime' => "1440150418",
				// 'transfer_customer_service' => "0",
				// 'openphotoprint' => "0",
				// 'freephotocount' => "3",
				// 'oauth' => "0",
				'color_id' => 0,

				'tpltypeid' => $temps [$this->config ['template_index']] ['tpltypeid'],
				'tpltypename' => $this->config ['template_index'],

				'tpllistid' => $temps [$this->config ['template_lists']] ['tpltypeid'],
				'tpllistname' => $this->config ['template_lists'],

				'tplcontentid' => $temps [$this->config ['template_detail']] ['tpltypeid'],
				'tplcontentname' => $this->config ['template_detail']
		);
		$this->assign ( 'tpl', $tpl );
		$this->assign ( 'wxuser', $tpl );
	}
	function pigcms_index() {
		$this->pigcms_init ();

		$cate = $this->_pigcms_cate ( 0 );
		$this->assign ( 'info', $cate );
	}
	function pigcms_lists($cate_id) {
		$this->pigcms_init ();

		$map ['token'] = get_token ();
		$cateArr = M ( 'weisite_category' )->where ( $map )->getField ( 'id,title' );

		$thisClassInfo = array ();
		if ($cate_id) {
			$map ['cate_id'] = $cate_id;

			$thisClassInfo = $this->_deal_cate ( $cateArr [$cate_id] );
		}

		$data = M ( 'custom_reply_news' )->where ( $map )->order ( 'sort asc, id DESC' )->select ();
		foreach ( $data as $vo ) {
			$info [] = array (
					'id' => $vo ['id'],
					'uid' => 0,
					'uname' => $vo ['author'],
					'keyword' => $vo ['keyword'],
					'type' => 2,
					'text' => $vo ['intro'],
					'classid' => $vo ['cate_id'],
					'classname' => $vo [''],
					'pic' => get_cover_url ( $vo ['cover'] ),
					'showpic' => 1,
					'info' => strip_tags ( htmlspecialchars_decode ( mb_substr ( $vo ['content'], 0, 10, 'utf-8' ) ) ),
					'url' => $this->_getNewsUrl ( $vo ),
					'createtime' => $vo ['cTime'],
					'uptatetime' => $vo ['cTime'],
					'click' => $vo ['view_count'],
					'token' => $vo ['token'],
					'title' => $vo ['title'],
					'usort' => $vo ['sort'],
					'name' => $vo ['title'],
					'img' => get_cover_url ( $vo ['cover'] )
			);
		}

		$this->assign ( 'info', $info );
		$this->assign ( 'thisClassInfo', $thisClassInfo );
	}
	function pigcms_detail() {
		$this->pigcms_init ();

		$cate = $this->_pigcms_cate ( 0 );
		$this->assign ( 'info', $cate );

		$map ['id'] = I ( 'get.id', 0, 'intval' );
		$res = M ( 'custom_reply_news' )->where ( $map )->find ();
		$res = $this->_deal_news ( $res, 1 );
		$this->assign ( 'res', $res );
		M ( 'custom_reply_news' )->where ( $map )->setInc ( 'view_count' );

		$map2 ['cate_id'] = $res ['cate_id'];
		$map2 ['id'] = array (
				'exp',
				'!=' . $map ['id']
		);
		$lists = M ( 'custom_reply_news' )->where ( $map2 )->order ( 'id desc' )->limit ( 5 )->select ();
		foreach ( $lists as &$new ) {
			$new = $this->_deal_news ( $new );
		}

		$this->assign ( 'lists', $lists );
	}
	function _pigcms_cate($pid = null) {
		$map ['token'] = get_token ();
		$map ['is_show'] = 1;
		$pid === null || $map ['pid'] = $pid; // 获取一级分类

		$category = M ( 'weisite_category' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
		$count = count ( $category );
		foreach ( $category as $k => $vo ) {
			$param ['cate_id'] = $vo ['id'];
			$url = empty ( $vo ['url'] ) ? $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', $param ) : $vo ['url'];
			$pid = intval ( $vo ['pid'] );
			$res [$pid] [$vo ['id']] = $this->_deal_cate ( $vo, $count - $k );
		}

		foreach ( $res [0] as $vv ) {
			if (! empty ( $res [$vv ['id']] )) {
				$vv ['sub'] = $res [$vv ['id']];
				unset ( $res [$vv ['id']] );
			}
		}

		return $res [0];
	}
	function _deal_cate($vo, $key = 1) {
		return array (
				'id' => $vo ['id'],
				'fid' => $vo ['pid'],
				'name' => $vo ['title'],
				'info' => $vo ['title'],
				'sorts' => $vo ['sort'],
				'img' => get_cover_url ( $vo ['icon'] ),
				'url' => $url,
				'status' => 1,
				'path' => empty ( $vo ['pid'] ) ? 0 : '0-' . $vo ['pid'],
				'tpid' => 1,
				'conttpid' => 1,
				'sub' => array (),
				'key' => $key,
				'token' => $vo ['token']
		);
	}
	function _deal_news($vo, $type = 0) {
		$map ['id'] = $vo ['cate_id'];
		return array (
				'id' => $vo ['id'],
				'uid' => 0,
				'uname' => $vo ['author'],
				'keyword' => $vo ['keyword'],
				'type' => 2,
				'text' => $vo ['intro'],
				'classid' => $vo ['cate_id'],
				'classname' => empty ( $vo ['cate_id'] ) ? '' : M ( 'weisite_category' )->where ( $map )->getField ( 'title' ),
				'pic' => get_cover_url ( $vo ['cover'] ),
				'showpic' => 1,
				'info' => $type == 0 ? strip_tags ( htmlspecialchars_decode ( mb_substr ( $vo ['content'], 0, 10, 'utf-8' ) ) ) : $vo ['content'],
				'url' => $this->_getNewsUrl ( $vo ),
				'createtime' => $vo ['cTime'],
				'uptatetime' => $vo ['cTime'],
				'click' => $vo ['view_count'],
				'token' => $vo ['token'],
				'title' => $vo ['title'],
				'usort' => $vo ['sort'],
				'name' => $vo ['title'],
				'img' => get_cover_url ( $vo ['cover'] )
		);
	}
	function _getNewsUrl($info) {
		$param ['token'] = get_token ();
		$param ['openid'] = get_openid ();

		if (! empty ( $info ['jump_url'] )) {
			$url = replace_url ( $info ['jump_url'] );
		} else {
			$param ['id'] = $info ['id'];
			$url = U ( 'detail', $param );
		}
		return $url;
	}
	/* 预览 */
	function preview(){
		$publicid = get_token_appinfo('','id');
	    $url = addons_url('WeiSite://WeiSite/index',array('publicid'=>$publicid));
	    $this->assign('url', $url);
	    $this->display(SITE_PATH . '/Application/Home/View/default/Addons/preview.html');
	}
}
