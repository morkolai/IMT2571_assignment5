<?php
/**
  * This file is a part of the code used in IMT2571 Assignment 5.
  *
  * @author Rune Hjelsvold
  * @version 2018
  */

require_once('Club.php');
require_once('Skier.php');
require_once('YearlyDistance.php');
require_once('Affiliation.php');

/**
  * The class for accessing skier logs stored in the XML file
  */  
class XmlSkierLogs
{
    /**
      * @var DOMDocument The XML document holding the club and skier information.
      */  
    protected $doc;

    protected $xpath;
    
    /**
      * @param string $url Name of the skier logs XML file.
      */  
    public function __construct($url)
    {
        $this->doc = new DOMDocument();
        $this->doc->load($url);
        $this->xpath = new DOMXpath($this->doc);
    }
    
    /**
      * The function returns an array of Club objects - one for each
      * club in the XML file passed to the constructor.
      * @return Club[] The array of club objects
      */
    public function getClubs()
    {
        $clubs = array();
        $nodes = $this->xpath->query('//SkierLogs/Clubs/Club');

        for($i = 0; $i < $nodes->length; $i++) {
          $id = $nodes->item($i)->attributes->item(0)->value;
          $name = $nodes->item($i)->childNodes->item(1)->childNodes->item(0)->nodeValue;
          $city = $nodes->item($i)->childNodes->item(3)->childNodes->item(0)->nodeValue;
          $county = $nodes->item($i)->childNodes->item(5)->childNodes->item(0)->nodeValue;
          $clubs[$i] = new Club($id, $name, $city, $county);
        }
        return $clubs;
    }

    /**
      * The function returns an array of Skier objects - one for each
      * Skier in the XML file passed to the constructor. The skier objects
      * contains affiliation histories and logged yearly distances.
      * @return Skier[] The array of skier objects
      */
    public function getSkiers()
    {
        $skiers = array();

        //Adding new skier
        $nodes = $this->xpath->query('//SkierLogs/Skiers/Skier');

        for($i = 0; $i < $nodes->length; $i++) {
          $userName = $nodes->item($i)->attributes->item(0)->value;
          $firstName = $nodes->item($i)->childNodes->item(1)->childNodes->item(0)->nodeValue;
          $lastName = $nodes->item($i)->childNodes->item(3)->childNodes->item(0)->nodeValue;
          $yearOfBirth = $nodes->item($i)->childNodes->item(5)->childNodes->item(0)->nodeValue;
          $skiers[$i] = new Skier($userName, $firstName, $lastName, $yearOfBirth);
        }

        //Adding affiliations to skier
        $path = $this->xpath->query('//SkierLogs/Season');

        for($i = 0; $i < $path->length; $i++) {
          $season = (int)$path->item($i)->attributes->item(0)->nodeValue;

          $path = $this->xpath->query('//SkierLogs/Season[@fallYear='.$season.']/Skiers');
          for($j = 0; $j < $path->length; $j++) {
            if($path->item($j)->attributes->length != 0) {
              $club = $path->item($j)->attributes->item(0)->nodeValue;

              $path = $this->xpath->query('//SkierLogs/Season[@fallYear="'.$season.'"]/Skiers[@clubId="'.$club.'"]/Skier');
              for($k = 0; $k < $path->length; $k++) {
                $userName = $path->item($k)->attributes->item(0)->nodeValue;

                for($l = 0; $l < count($skiers); $l++) {
                  if($userName == $skiers[$l]->userName) {
                    $skiers[$l]->affiliations[$i] = new Affiliation($club,$season);
                  }
                }
              }
            }
            $path = $this->xpath->query('//SkierLogs/Season[@fallYear='.$season.']/Skiers');
          }

          $path = $this->xpath->query('//SkierLogs/Season[@fallYear='.$season.']/Skiers/Skier');

          for($j = 0; $j < $path->length; $j++) {
            $userName2 = $path->item($j)->attributes->item(0)->nodeValue;

            $path = $this->xpath->query('//SkierLogs/Season[@fallYear='.$season.']/Skiers/Skier[@userName="'.$userName2.'"]/Log/Entry/Distance');
            $distance = 0;
            for($k = 0; $k < $path->length; $k++) {
              $distance += (int)$path->item($k)->childNodes->item(0)->nodeValue;
            }
            for($k = 0; $k < count($skiers); $k++) {
              if($userName2 == $skiers[$k]->userName) {
                $skiers[$k]->yearlyDistances[$i] = new YearlyDistance($season, $distance);
              }
            }
            $path = $this->xpath->query('//SkierLogs/Season[@fallYear='.$season.']/Skiers/Skier');
          }
          $path = $this->xpath->query('//SkierLogs/Season');
        }
        // TODO: Implement the function retrieving skier information,
        //       including affiliation history and logged yearly distances.
       return $skiers;
    }  
}

//For testing
$bob = new XMLSkierLogs('../../SkierLogs.xml');


?>