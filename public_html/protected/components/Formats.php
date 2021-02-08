<?php
class Formats {
	
	public static function getCountPrice($count)
	{
		$val = (int)$count;
		if( $val == 1)
			return 'рубль';
		else {
			if ($val > 10 && $val < 20) { return ' рублей' ;}
			else {
				$val = (int)$count % 10;
				if ($val == 1) { return ' рубль';
				} else if ($val > 1 && $val < 5) { return ' рубля';
				} else { return ' рублей';}
			}
		}
	}
	
	public static function getCountProducts($count)
	{
		$val = (int)$count;
		if( $val == 1)
			return 'товар';
		else {
			if ($val > 10 && $val < 20) { return ' товаров' ;}
			else {
				$val = (int)$count % 10;
				if ($val == 1) { return ' товар';
				} else if ($val > 1 && $val < 5) { return ' товара';
				} else { return ' товаров';}
			}
		}
	}
	
	public static function getCoockieSort()
	{
		$sort = array(
			'type' => 'Все',
			'price' => '',
			'sort' => '',
			'smbig' => 'big',
		);
		
		$coockie = (string)Yii::app()->request->cookies['sort'];
		
		if ($coockie != '') {
			$ARR = CJSON::decode($coockie);
			if (isset($sort['type']) && isset($sort['price']) && isset($sort['sort']) && isset($sort['smbig']))
				$sort = $ARR;
		}
		
		return $sort;
	}
	
	public static function setCoockieSort($array)
	{
		
		Yii::app()->request->cookies['sort'] = new CHttpCookie('sort', CJSON::encode($array));
	}
	
	
	public static function getCountItems($count)
	{
		
		$val = (int)$count;
		
		if ($val > 10 && $val < 20) { return $count.' штук' ;}
		else {
			$val = (int)$count % 10;
			if ($val == 1) { return $count.' штука';
		    } elseif ($val == 0) { return $count.' штук';
			} else if ($val > 1 && $val < 5) { return $count.' штуки';
			} else { return $count.' штук';}
		}
		
	}
	
	public static function getFormatDate($ts) {
	
		if ((int)$ts == 0) return 'сейчас';
		$arrMonth = array(
				'01' => 'января',
				'02' => 'февраля',
				'03' => 'марта',
				'04' => 'апреля',
				'05' => 'мая',
				'06' => 'июня',
				'07' => 'июля',
				'08' => 'августа',
				'09' => 'сентября',
				'10' => 'октября',
				'11' => 'ноября',
				'12' => 'декабря',
		);
	
		$month_id = strftime('%m', $ts);
	
		$date = strftime('%e '.$arrMonth[$month_id].' %Y в %H:%M', $ts);
	
		return $date;
	
	
	}
	
	public static function getIframeVideo($link, $msize) {
		$iframe = '';
		
		if (isset($link) && $link != ''){
				
			if (preg_match('/instagram.com/', $link)){
				if (preg_match('/embed/', $link))
					$iframe_src = $link;
				else {
					$iframe_src  = preg_replace('/^([^#]+)#$/is','$1', $link).'embed';
				}
				if ($msize  == 520){
					$iframe = '
							<div class="post_video_embed" style="overflow:hidden;margin:10px 0; width:536px;height:520px;margin-left:-8px;">
								<iframe src="'.$iframe_src.'" width="536" height="603" style="margin-top:-50px;"  padding="0" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowtransparency="true"></iframe>
							</div>
					';
				} else {
					$iframe = '
							<div class="post_video_embed" style="overflow:hidden;margin:10px 0;width:621px; height:612px; margin-left:-8px;">
								<iframe src="'.$iframe_src.'" width="612" height="710" style="max-width:612px;margin-top:-50px;"  frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowtransparency="true"></iframe>
							</div>
							';
				}
		
			} elseif (preg_match('/youtube.com/', $link)){
				$iframe_src = '';
				if (preg_match('/embed/', $link))
					$iframe_src = $link;
				else {
					$iframe_src  = '//www.youtube.com/embed/'.preg_replace('/^[^\?]+\?v=(.+)$/is','$1', $link).'';
				}
		
				if ($msize  == 520){
					$iframe = '
							<div class="post_video_embed" style="margin:10px 0;">
								<iframe width="520" height="290" src="'.$iframe_src.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>
					';
				} else {
					$iframe = '
							<div class="post_video_embed" style="margin:10px 0;">
								<iframe width="750" height="420" src="'.$iframe_src.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>
							';
				}
		
			} elseif (preg_match('/vimeo.com/', $link)){
				$iframe_src = '';
				if (preg_match('/player/', $link))
					$iframe_src = $link;
				else {
						
					$iframe_src  = '//player.vimeo.com/video/'.preg_replace('/^.+\/(.+)$/is','$1', $link).'';
				}
					
				if ($msize  == 520){
					$iframe = '
						<div class="post_video_embed" style="margin:10px 0;">
							<iframe width="520" height="290" src="'.$iframe_src.'"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
				';
				} else {
					$iframe = '
						<div class="post_video_embed" style="margin:10px 0;">
							<iframe width="750" height="420" src="'.$iframe_src.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
						';
						
				}
		
		
			}
			
			
		}
		
			return $iframe;
	
	}
	
	public static function end_eyai($num) {
		$ost=$num%10;
		$ost100 = $num%100;
		if (($ost100<10 || $ost100>20) && $ost!=0) {
			switch ($ost) {
				case 1:	$end='е';	break;
				case 2:
				case 3:
				case 4: $end='я'; break;
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:	$end='й'; break;
			}
		} else $end='й';
		return $end;
	}
	
}