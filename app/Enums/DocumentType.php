<?php namespace App\Enums;
enum DocumentType: string {
    case NationalId          = 'national_id';
    case Passport            = 'passport';
    case DriversLicence      = 'drivers_licence';
    case Selfie              = 'selfie';
    case ProofOfQualification = 'proof_of_qualification';
    case ProofOfAddress      = 'proof_of_address';
    case Other               = 'other';
}
