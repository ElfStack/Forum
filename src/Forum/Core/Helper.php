<?php
namespace ElfStack\Forum\Core;

class Helper
{
	static public function random($n, $dic = null)
	{
		$dic = empty($dic) ? 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' : $dic;
		$result = '';
		for ($i = 0; $i < $n; $i++){
			$result .= $dic[mt_rand(0, strlen($dic) - 1)];
		}
		return $result;
	}

	static public function ensureCanSave(RequiredAttrInterface $obj, $throws = true)
	{
		$result = $obj->validateAttr();
		if ($result === true) {
			return true;
		}
		if ($throws) {
			throw new Exception($result);
		}
		return $result;
	}
}
