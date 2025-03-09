<?php

namespace App\Enums;

enum TeethTypes: string 
{
    case CAD_CAM = 'Cad Cam';
    case ZARCONIA = 'Zarconia';
    case VENEER = 'Veneer';
    case ATTACHMENT = 'Attachment';
    case PROCELAIN_STYLE = 'Procelain Style';
    case PROCELAIN_DESIGN = 'Procelain Design';
    case PROCELAIN_CLASSIC = 'Procelain Classic';
    case PROCELAIN_PRO_SHOFO = 'Procelain Pro Shofo';
    case PROCELAIN_NORITAKE = 'Procelain Noritake';
    case METAL_SUPREMA_CAST = 'Metal Suprema Cast';
    case GOLDEN_PRO = 'Golden Pro';
    case FULL_DENTURE = 'Full Denture';
    case CC_PLATE = 'CC Plate';
    case FULL_NIGHT_GUARD = 'Full Night Guard';

    public static function getValues(): array 
    {
        return array_column(self::cases(), 'value');
    }
}
