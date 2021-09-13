<?php

class DatabaseInfo extends \Backend implements \executable
{

	// Core-Inhaltselemente
	protected $CoreElements = array
	(
		'headline'       ,
		'text'           ,
		'html'           ,
		'list'           ,
		'table'          ,
		'code'           ,
		'accordionSingle',
		'accordionStart' ,
		'accordionStop'  ,
		'sliderStart'    ,
		'sliderStop'     ,
		'hyperlink'      ,
		'toplink'        ,
		'image'          ,
		'gallery'        ,
		'player'         ,
		'youtube'        ,
		'download'       ,
		'downloads'      ,
		'article'        ,
		'alias'          ,
		'form'           ,
		'module'         ,
		'teaser'         
	);

	public function isActive()
	{
		return '';
	}

	public function run()
	{
		// Alle Inhaltselemente feststellen
		$arrElementsCount = array();
		$arrElementsCore = array();
		$arrElementsArray = array();
		foreach($GLOBALS['TL_CTE'] as $array => $value)
		{
			foreach($GLOBALS['TL_CTE'][$array] as $key => $value)
			{
				$arrElementsCount[$key] = 0; // Initialisieren
				$arrElementsArray[$key] = $array; // Bereich zuweisen
				(in_array($key, $this->CoreElements)) ? $arrElementsCore[$key] = true : $arrElementsCore[$key] = false; 
			}
		}
		
		$arrJobs               = array();
		$objTemplate           = new \BackendTemplate('be_database_info');
		$objTemplate->isActive = $this->isActive();

		$objTemplate->message  = 'Info von Mir für Euch';
		$objTemplate->headline = $GLOBALS['TL_LANG']['tl_maintenance']['database_info_content'];

		$objContent = $this->Database->prepare("SELECT type, COUNT(*) AS anzahl FROM tl_content GROUP BY type")->execute();
		while($objContent->next())
		{
			$arrElementsCount[$objContent->type] = $objContent->anzahl;
		}
		arsort($arrElementsCount, SORT_NUMERIC);

		$objTemplate->arrElementsCount  = $arrElementsCount;
		$objTemplate->arrElementsCore  = $arrElementsCore;
		$objTemplate->arrElementsArray  = $arrElementsArray;

		return $objTemplate->parse();
	}
}
