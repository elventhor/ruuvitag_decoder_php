<?php
function _bin16dec($bin) {
    // converts 16bit binary number string to integer using two's complement
    $num = bindec($bin) & 0xFFFF; // only use bottom 16 bits
    if (0x8000 & $num) {
        $num = - (0x010000 - $num);
    }
    return $num;
} // Thanks: http://stackoverflow.com/a/16127799

function ruuvi($hex)
{

        // convert hex to binary
        $bin = hex2bin($hex);
  
        // https://www.php.net/manual/en/function.pack.php
        // https://github.com/ruuvi/ruuvi-sensor-protocols/blob/master/dataformat_05.md
  
        $dataArray = unpack("c1length/c1flags/c1flagvalue/c1payloadlength/H2type/H4manufacturer/c1format/H4temp/H4humi/H4pres/H4accx/H4accy/H4accz/H4power/c1movement/H4sequence/H12mac",$bin);

        if($dataArray['manufacturer'] != "9904") {
                // Not a ruuvtag
                return false;
        }
        if($dataArray['format'] != 5) {
                // Wrong rormat
                return false;
        }
        $dataArray['temperature'] = hexdec($dataArray['temp'])*0.005;
        $dataArray['humidity'] = hexdec($dataArray['humi'])*0.0025;
        $dataArray['pressure'] = hexdec($dataArray['pres'])-50000;

        return ($dataArray);
}

