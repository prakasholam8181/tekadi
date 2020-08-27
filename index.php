<?php
	$data = file_get_contents("res.json");  
    $tasks = json_decode($data, true);
	print_r($tasks);
	echo '<br>';
	echo '<br>';

	class NestingUtil
	{
		public static function nest(&$records, $recordPropId = 'id', $parentPropId = 'parent', $childWrapper = 'children', $parentId = null)
	    {
	        $nestedRecords = [];
	        foreach ($records as $index => $children) {
	            if (isset($children[$parentPropId]) && $children[$parentPropId] == $parentId) {
	                unset($records[$index]);
	                $children[$childWrapper] = self::nest($records, $recordPropId, $parentPropId, $childWrapper, $children[$recordPropId]);
	                $nestedRecords[] = $children;
	            }
	        }

	        if (!$parentId) {
			    //merge residual records with the nested array
			    $nestedRecords = array_merge($nestedRecords, $records);
			}

	        return $nestedRecords;
	    }

	}

	$employees = json_decode($data, true);
	$managers = NestingUtil::nest($employees, 'id', 'parent', 'children');
	print_r(json_encode($managers));

?>