<?php

namespace App\Logic\Address;

use GuzzleHttp\Client;

/*
* Helper Class to wrap the calls to the Mapzen geocoding api in convenient methods
*
*/

/**
 * Class AddressAPI
 * @package App\Logic\Address
 * @author: Konrad Pozniak
 *
 * Helper Class to wrap the calls to the Mapzen geocoding api in convenient methods
 *
 */
class AddressAPI
{
   /**
    * @param $fullAddress
    * @return null
    * Returns the coordinates of the specified address, or null if an error occured
    */
   public function getCoordinates($street, $streetnumber, $zip) {

      $json = $this->query($street.' '.$streetnumber.' '.$zip);

      if ($json === null) {
         return null;
      }

      $feature = $json['features'][0];
      $properties = $feature['properties'];

      if (strcmp($properties['street'], $street) == 0 && strcmp($properties['housenumber'], $streetnumber) && strcmp($properties['postalcode'], $zip)) {
         return $feature['geometry']['coordinates'];
      }

      return null;
   }

   /**
    * @param $input
    * @return array
    * Returns an array of address suggestions, or an empty array if an error occurs or no suggestions were found
    */
   public function getAddressSuggestions($input)
   {
      $returnArray = array();

      $json = $this->query($input);

      if($json == null) {
         return $returnArray;
      }

      $features = $json['features'];

      foreach ($features as $feature) {
         $properties = $feature['properties'];

         if(array_key_exists("street", $properties) &&
             array_key_exists("housenumber", $properties) &&
             array_key_exists("locality", $properties) &&
             array_key_exists("postalcode", $properties)) {
            $returnAddress = array (
                "street" => $properties['street'],
                "number" => $properties['housenumber'],
                "city" => $properties['locality'],
                "zip" => $properties['postalcode']
            );

            $returnArray[] = $returnAddress;
         }
      }

      return $returnArray;
   }

   /**
    * @param $input
    * @return mixed|null
    * Queries the mapzen API for adresses within an radius of 35 kilometers around vienna. Returns null if an error occured
    */
   private function query($input) {

      if (empty($input)) {
         return null;
      }

      $client = new Client();
      $response = $client->request('GET', 'https://search.mapzen.com/v1/search', [
          'query' => ['text' => $input, 'api_key' => 'search-pTjgegT', 'layers' => 'address',
              'boundary.circle.lat' =>	48.208493,
              'boundary.circle.lon' =>	16.373118,
              'boundary.circle.radius' => 35 ]
      ]);


      return json_decode($response->getBody(), true);
   }
}

?>
