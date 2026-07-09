<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.register',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.login',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.generated::jCYOcHmzojrTNsOt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tiers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ekVQpwqvVQZbFQ7z',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/fcm-token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dj2Lxev8wsgIRNJh',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::m2QaEJyAXeIACkRB',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lJVhtqZGTCz1AfUy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/notifications/read-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZVarDzd4HgOApea7',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/institutions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dHnPBdn40RmLdRHt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gSB34k7LSJDWu81k',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/email/verify/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email.status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/email/verification-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.me',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user/profile/avatar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.avatar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.password.change',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payment/methods' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.methods',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payment/deposit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.deposit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payment/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.transactions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/payment/gateways' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.gateways.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::86jpZzuGEWdhjMEj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oXdJrOZDUdq0zXuB',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/bookings/upcoming/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XD9sz0fEDLE0RNE4',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/wallet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HPK3OtXhwqwzjLWv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/wallet/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NiZNrssRczV1bu4r',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payout/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2HNMtvj6bodecnoa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RoqGrD76GIdqqbJw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payout/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2Cr4Ek4nYimpx4mp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payout/request' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HRgDb1e3ntxOcluc',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor/bookings/requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4yQfWmTX6EM6CdRX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor/availability' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8uM4ymxZyARBOB1V',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oquVbrRSMPIg2XJn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor/availability/bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::65pePsiQYc2jq8lw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor/availability/replace' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lW0DYS2SKD45DouF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor/tier/progress' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::SnSAS5RFRE770GfS',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mmtMExAkHu2CXci1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/kyc/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZQ2iTEb5PWhSEjV1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/kyc/applications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LGIUTi9AgVd8gSoH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/tiers/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::g8kpEVWYsUnTq3Xs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/tiers/commission-preview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6aOCEl81zVF3otsE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/tiers/re-evaluate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CknH022DROzDivnT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/tiers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::meYey23jT8rwtJAN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jbgP8TUR0rEVpfLr',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/kyc/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Hq0MpmAPmiQxMau5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/kyc/apply' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3MvBp183f7JHyjlD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/kyc/documents' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PB55pK4QFAAj3nOi',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JsSaIqVnPrnalY7h',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/how-it-works' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'how-it-works',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/pricing' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pricing',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'register.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/legal/privacy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'legal.privacy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/legal/terms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'legal.terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/consent' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'consent.show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'consent.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.notice',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/verification-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/institutions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.institutions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.institutions.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.subjects.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.subjects.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/kyc' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.kyc.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sessions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/payouts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payouts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/gateways' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.gateways.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tiers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tiers/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.settings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/settings/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.settings.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/financials' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.financials.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/audit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.audit.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/notifications/broadcast' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notifications.broadcast',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notifications.broadcast.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/notifications/broadcast/search-users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notifications.broadcast.search-users',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reviews.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/avatar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.avatar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/availability' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/availability/bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.bulk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/availability/replace' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.replace',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/bookings/requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.requests',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/wallet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/wallet/payouts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.payouts',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/wallet/payout/request' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.payout.request',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/wallet/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.payout-account.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/kyc' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.kyc.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/kyc/apply' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.kyc.apply',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/kyc/documents' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.kyc.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/discover' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.discover',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/institutions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.institutions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.subjects.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/wallet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.wallet.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/wallet/deposit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.wallet.deposit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/wallet/gateway-redirect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.wallet.gateway-redirect',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/guardians' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.guardians.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'student.guardians.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile.edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/profile/avatar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile.avatar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.notifications.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'settings.notifications.reset',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/read-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.read-all',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/broadcasting/auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::M0CjrEwIyGGLypr2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/a(?|pi/(?|pay(?|ment/(?|webhook/([^/]++)(*:48)|callback/([^/]++)(*:72)|booking/([^/]++)(*:95))|out/(?|accounts/([^/]++)(?|/default(*:138)|(*:146))|([^/]++)/cancel(*:170)))|t(?|iers/([^/]++)(*:197)|utor(?|/availability/([^/]++)(?|(*:237)|/toggle(*:252)|(*:260))|s/([^/]++)(?|/(?|availability(*:298)|reviews(*:313))|(*:322))))|notifications/([^/]++)/read(*:360)|email/verify/([^/]++)/([^/]++)(*:398)|admin/(?|payment/gateways/([^/]++)(?|(*:443)|/(?|configure(*:464)|t(?|oggle(*:481)|est(*:492))))|bookings/([^/]++)/dispute(*:528)|kyc/(?|applications/([^/]++)(?|(*:567)|/(?|flag(*:583)|approve(*:598)|reject(*:612)))|documents/([^/]++)/url(*:644))|tiers/([^/]++)(?|(*:670)|/(?|toggle(*:688)|assign(*:702))))|bookings/([^/]++)(?|(*:733)|/(?|cancel(*:751)|review(*:765)|accept(*:779)|decline(*:794)|session(*:809)))|sessions/([^/]++)(?|(*:839)|/(?|join(*:855)|token/refresh(*:876)|keepalive(*:893)|start(*:906)|end(*:917)|report(*:931)|chat(?|(*:946)|/(?|read(*:962)|unread(*:976)))|polls(?|(*:994)|/([^/]++)(?|(*:1014)|/(?|respond(*:1034)|close(*:1048))))))|invoices/([^/]++)(?|(*:1082)|/download(*:1100))|kyc/documents/([^/]++)(*:1132))|dmin/(?|users/([^/]++)(?|(*:1167)|/(?|s(?|uspend(*:1190)|end\\-reset\\-link(*:1215))|ban(*:1228)|activate(*:1245)|update\\-password(*:1270)))|institutions/([^/]++)(?|(*:1305))|s(?|ubjects/([^/]++)(?|(*:1338))|essions/([^/]++)/force\\-end(*:1375))|kyc/([^/]++)(?|(*:1400)|/(?|approve(*:1420)|reject(*:1435)))|payout(?|s/([^/]++)/(?|processing(*:1479)|complete(*:1496)|fail(*:1509))|\\-accounts/([^/]++)/(?|verify(*:1548)|unverify(*:1565)))|gateways/([^/]++)(?|(*:1596)|/(?|configure(*:1618)|toggle(*:1633)))|tiers/([^/]++)(?|/(?|edit(*:1669)|toggle(*:1684))|(*:1694))|bookings/([^/]++)(?|(*:1724)|/(?|cancel(*:1743)|resolve\\-dispute(*:1768)))|re(?|views/([^/]++)(?|/(?|hide(*:1809)|restore(*:1825))|(*:1835))|ports/([^/]++)/(?|under\\-review(*:1876)|warn(*:1889)|suspend(*:1905)|dismiss(*:1921)))))|/reset\\-password/([^/]++)(*:1959)|/s(?|e(?|ssions/([^/]++)/(?|chat(*:2000)|report(*:2015))|ttings/notifications/(?|([^/]++)(*:2057)|bulk(*:2070)))|t(?|udent/(?|tutors/([^/]++)(*:2109)|bookings/(?|create/([^/]++)(*:2145)|([^/]++)(?|(*:2165)|/(?|cancel(*:2184)|review(*:2199))))|sessions/([^/]++)(?|(*:2231)|/end(*:2244))|guardians/([^/]++)(?|(*:2275)))|orage/(.*)(?|(*:2299))))|/email/verify/([^/]++)/([^/]++)(*:2342)|/tutor(?|/(?|availability/([^/]++)(?|(*:2388)|/toggle(*:2404)|(*:2413))|bookings/([^/]++)(?|(*:2443)|/(?|accept(*:2462)|decline(*:2478)|cancel(*:2493)))|sessions/([^/]++)(?|(*:2524)|/(?|start(*:2542)|end(*:2554)))|wallet/(?|payout/([^/]++)/cancel(*:2597)|accounts/([^/]++)(?|/default(*:2634)|(*:2643)))|kyc/documents/([^/]++)(*:2676))|s/([^/]++)/reviews(*:2704))|/invoices/([^/]++)(?|(*:2735)|/download(*:2753))|/notifications/([^/]++)/read(*:2791))/?$}sDu',
    ),
    3 => 
    array (
      48 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.webhook',
          ),
          1 => 
          array (
            0 => 'gateway',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      72 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.callback',
          ),
          1 => 
          array (
            0 => 'gateway',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      95 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.booking.pay',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      138 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UHEfIlgE7h9aQWgJ',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      146 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::G82WaNYu1hGC785Q',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      170 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OiZKBowQ8OK9GBDV',
          ),
          1 => 
          array (
            0 => 'payout',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      197 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vwMPneJgNnjRYSTv',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      237 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::19mhSjtGZqSH66x4',
          ),
          1 => 
          array (
            0 => 'slot',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      252 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::F05a5YJsg8TgiP7P',
          ),
          1 => 
          array (
            0 => 'slot',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      260 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wuLgWsL6C2o7QwSE',
          ),
          1 => 
          array (
            0 => 'slot',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      298 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sGAMCJzBS7D6OJKl',
          ),
          1 => 
          array (
            0 => 'tutorId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      313 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LamwvRSssHNlpg1z',
          ),
          1 => 
          array (
            0 => 'tutor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      322 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ivZ1CAxzsNB6hpyt',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      360 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lL2mZPxjNptL2kA2',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      398 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email.verify',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      443 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.gateways.show',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      464 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.gateways.configure',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      481 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.gateways.toggle',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      492 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.gateways.test',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      528 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GPLdhKahjG6NqYFP',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      567 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oCHZ7tn4ovLb4vPP',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      583 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XbG68bpdbLg6fGT1',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      598 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZtoqcGjpSWUv2uQ4',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      612 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WyOLfKbsmze6C9zk',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      644 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1AErk2UhgWTYqT16',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      670 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kY3wRTR5d45K9E6e',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UeZ6EgwsHDK3DR0v',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oZzH92DBGTKylLT9',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      688 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vC3BybTo7fKNm0Ex',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      702 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zlnYs1HCB0zGnQ3n',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      733 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bQFHLahKrZB0Rd1a',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      751 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wcDfqFCT8rkecyU5',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      765 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6v72GFjx2B0o6MIi',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      779 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lG4ur6xlKoS6T5m7',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      794 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xlUT7FUEghIk21eL',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      809 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jjlKhnZ1PDUMMw1S',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      839 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::G1jJusCBregvUuow',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      855 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kobskE1IJTolJX6O',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      876 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5YLI2nJA6MZSn7f5',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      893 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::k7eQM5EmgjvOAjKw',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      906 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7pLTxBds4Sx7sLTA',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      917 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZxPSGLjrSusC1H6C',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      931 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FX1SWa8KWEBWj9GB',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      946 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::j0D7eVvrJgjdNuKp',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dZK0nEt63Jz12V9v',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      962 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kgjS2myH2o0utPWy',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      976 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fLGEjOGQkQGRmXM2',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      994 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2gXb5O9NTlZ0PTfe',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZJ9Xb1DZavzZprha',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1014 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eC56SjcHWWYk7ZXG',
          ),
          1 => 
          array (
            0 => 'session',
            1 => 'poll',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1034 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CYaCPZiUfSw6HHdT',
          ),
          1 => 
          array (
            0 => 'session',
            1 => 'poll',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1048 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DOIuuSW7OA8C994m',
          ),
          1 => 
          array (
            0 => 'session',
            1 => 'poll',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1082 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZWwDvrgidiP3IWQO',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1100 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.invoices.download',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1132 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Fi53LddPCYxt8ive',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1167 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.show',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1190 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.suspend',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1215 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.send-reset-link',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1228 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.ban',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1245 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.activate',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1270 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.update-password',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1305 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.institutions.update',
          ),
          1 => 
          array (
            0 => 'institution',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.institutions.destroy',
          ),
          1 => 
          array (
            0 => 'institution',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1338 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.subjects.update',
          ),
          1 => 
          array (
            0 => 'subject',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.subjects.destroy',
          ),
          1 => 
          array (
            0 => 'subject',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1375 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sessions.force-end',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1400 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.kyc.show',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1420 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.kyc.approve',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1435 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.kyc.reject',
          ),
          1 => 
          array (
            0 => 'application',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1479 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payouts.processing',
          ),
          1 => 
          array (
            0 => 'payout',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1496 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payouts.complete',
          ),
          1 => 
          array (
            0 => 'payout',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1509 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payouts.fail',
          ),
          1 => 
          array (
            0 => 'payout',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1548 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payout-accounts.verify',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1565 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payout-accounts.unverify',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1596 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.gateways.show',
          ),
          1 => 
          array (
            0 => 'method',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1618 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.gateways.configure',
          ),
          1 => 
          array (
            0 => 'method',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1633 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.gateways.toggle',
          ),
          1 => 
          array (
            0 => 'method',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1669 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.edit',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1684 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.toggle',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1694 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.update',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tiers.destroy',
          ),
          1 => 
          array (
            0 => 'tier',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1724 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookings.show',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1743 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookings.cancel',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1768 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookings.resolve-dispute',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1809 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reviews.hide',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1825 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reviews.restore',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1835 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reviews.destroy',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1876 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.under-review',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1889 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.warn',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1905 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.suspend',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1921 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.dismiss',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1959 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2000 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sessions.chat.send',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2015 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sessions.report',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2057 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.notifications.update',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2070 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.notifications.bulk',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2109 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.tutor.profile',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2145 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings.create',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2165 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings.show',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2184 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings.cancel',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2199 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings.review',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2231 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.session.join',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.session.end',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2275 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.guardians.update',
          ),
          1 => 
          array (
            0 => 'guardian',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'student.guardians.destroy',
          ),
          1 => 
          array (
            0 => 'guardian',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2299 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.public',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'storage.public.upload',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2342 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.verify',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2388 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.update',
          ),
          1 => 
          array (
            0 => 'slot',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2404 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.toggle',
          ),
          1 => 
          array (
            0 => 'slot',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2413 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.availability.destroy',
          ),
          1 => 
          array (
            0 => 'slot',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2443 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.show',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2462 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.accept',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2478 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.decline',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2493 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.cancel',
          ),
          1 => 
          array (
            0 => 'booking',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2524 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.sessions.show',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2542 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.sessions.start',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2554 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.sessions.end',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2597 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.payout.cancel',
          ),
          1 => 
          array (
            0 => 'payout',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2634 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.payout-account.default',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2643 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.wallet.payout-account.delete',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2676 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.kyc.document.destroy',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2704 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutors.reviews',
          ),
          1 => 
          array (
            0 => 'tutor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2735 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.show',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2753 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.download',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2791 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.read',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auth.register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\RegisterController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\RegisterController',
        'as' => 'auth.register',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auth.login' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\LoginController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\LoginController',
        'as' => 'auth.login',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auth.' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\PasswordResetController@sendLink',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\PasswordResetController@sendLink',
        'as' => 'auth.',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auth.generated::jCYOcHmzojrTNsOt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\PasswordResetController@reset',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\PasswordResetController@reset',
        'as' => 'auth.generated::jCYOcHmzojrTNsOt',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.webhook' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payment/webhook/{gateway}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payment\\WebhookController@handle',
        'controller' => 'App\\Http\\Controllers\\Api\\Payment\\WebhookController@handle',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'payment.webhook',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.callback' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/payment/callback/{gateway}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@callback',
        'controller' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@callback',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'payment.callback',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ekVQpwqvVQZbFQ7z' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tiers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\TierController@index',
        'controller' => 'App\\Http\\Controllers\\TierController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ekVQpwqvVQZbFQ7z',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vwMPneJgNnjRYSTv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tiers/{tier}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\TierController@show',
        'controller' => 'App\\Http\\Controllers\\TierController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::vwMPneJgNnjRYSTv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auth.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\LogoutController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\LogoutController',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'auth.logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dj2Lxev8wsgIRNJh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/fcm-token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\FcmTokenController@store',
        'controller' => 'App\\Http\\Controllers\\FcmTokenController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::dj2Lxev8wsgIRNJh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::m2QaEJyAXeIACkRB' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/fcm-token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\FcmTokenController@destroy',
        'controller' => 'App\\Http\\Controllers\\FcmTokenController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::m2QaEJyAXeIACkRB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lJVhtqZGTCz1AfUy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Notification\\NotificationController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Notification\\NotificationController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::lJVhtqZGTCz1AfUy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lL2mZPxjNptL2kA2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/notifications/{id}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Notification\\NotificationController@markRead',
        'controller' => 'App\\Http\\Controllers\\Api\\Notification\\NotificationController@markRead',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::lL2mZPxjNptL2kA2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZVarDzd4HgOApea7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/notifications/read-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Notification\\NotificationController@markAllRead',
        'controller' => 'App\\Http\\Controllers\\Api\\Notification\\NotificationController@markAllRead',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZVarDzd4HgOApea7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dHnPBdn40RmLdRHt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/institutions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Reference\\ReferenceDataController@institutions',
        'controller' => 'App\\Http\\Controllers\\Api\\Reference\\ReferenceDataController@institutions',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::dHnPBdn40RmLdRHt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gSB34k7LSJDWu81k' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Reference\\ReferenceDataController@subjects',
        'controller' => 'App\\Http\\Controllers\\Api\\Reference\\ReferenceDataController@subjects',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::gSB34k7LSJDWu81k',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/email/verify/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\EmailVerificationController@status',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\EmailVerificationController@status',
        'as' => 'email.status',
        'namespace' => NULL,
        'prefix' => 'api/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/email/verification-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\EmailVerificationController@send',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\EmailVerificationController@send',
        'as' => 'email.send',
        'namespace' => NULL,
        'prefix' => 'api/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/email/verify/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'signed',
          4 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Auth\\EmailVerificationController@verify',
        'controller' => 'App\\Http\\Controllers\\Api\\Auth\\EmailVerificationController@verify',
        'as' => 'email.verify',
        'namespace' => NULL,
        'prefix' => 'api/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user.me' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@me',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@me',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'user.me',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user.profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/user/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'user.profile.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user.profile.avatar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/user/profile/avatar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@avatar',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@avatar',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'user.profile.avatar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user.password.change' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/user/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@changePassword',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@changePassword',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'user.password.change',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.methods' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/payment/methods',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@methods',
        'controller' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@methods',
        'as' => 'payment.methods',
        'namespace' => NULL,
        'prefix' => 'api/payment',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.deposit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payment/deposit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@deposit',
        'controller' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@deposit',
        'as' => 'payment.deposit',
        'namespace' => NULL,
        'prefix' => 'api/payment',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.booking.pay' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payment/booking/{booking}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@payBooking',
        'controller' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@payBooking',
        'as' => 'payment.booking.pay',
        'namespace' => NULL,
        'prefix' => 'api/payment',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.transactions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/payment/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@transactions',
        'controller' => 'App\\Http\\Controllers\\Api\\Payment\\PaymentController@transactions',
        'as' => 'payment.transactions',
        'namespace' => NULL,
        'prefix' => 'api/payment',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.gateways.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/payment/gateways',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@index',
        'as' => 'admin.payment.gateways.index',
        'namespace' => NULL,
        'prefix' => 'api/admin/payment/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.gateways.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/payment/gateways/{code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@show',
        'as' => 'admin.payment.gateways.show',
        'namespace' => NULL,
        'prefix' => 'api/admin/payment/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.gateways.configure' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/payment/gateways/{code}/configure',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@configure',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@configure',
        'as' => 'admin.payment.gateways.configure',
        'namespace' => NULL,
        'prefix' => 'api/admin/payment/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.gateways.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/payment/gateways/{code}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@toggle',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@toggle',
        'as' => 'admin.payment.gateways.toggle',
        'namespace' => NULL,
        'prefix' => 'api/admin/payment/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.gateways.test' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/payment/gateways/{code}/test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@test',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\GatewayConfigController@test',
        'as' => 'admin.payment.gateways.test',
        'namespace' => NULL,
        'prefix' => 'api/admin/payment/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::86jpZzuGEWdhjMEj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@index',
        'controller' => 'App\\Http\\Controllers\\BookingController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::86jpZzuGEWdhjMEj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bQFHLahKrZB0Rd1a' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/bookings/{booking}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@show',
        'controller' => 'App\\Http\\Controllers\\BookingController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::bQFHLahKrZB0Rd1a',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XD9sz0fEDLE0RNE4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/bookings/upcoming/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@upcoming',
        'controller' => 'App\\Http\\Controllers\\BookingController@upcoming',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::XD9sz0fEDLE0RNE4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wcDfqFCT8rkecyU5' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/bookings/{booking}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@cancel',
        'controller' => 'App\\Http\\Controllers\\BookingController@cancel',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::wcDfqFCT8rkecyU5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HPK3OtXhwqwzjLWv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Wallet\\WalletController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Wallet\\WalletController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::HPK3OtXhwqwzjLWv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NiZNrssRczV1bu4r' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallet/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Wallet\\WalletController@transactions',
        'controller' => 'App\\Http\\Controllers\\Api\\Wallet\\WalletController@transactions',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::NiZNrssRczV1bu4r',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2HNMtvj6bodecnoa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/payout/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@accounts',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@accounts',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::2HNMtvj6bodecnoa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RoqGrD76GIdqqbJw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payout/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@storeAccount',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@storeAccount',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::RoqGrD76GIdqqbJw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UHEfIlgE7h9aQWgJ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payout/accounts/{account}/default',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@setDefaultAccount',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@setDefaultAccount',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::UHEfIlgE7h9aQWgJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::G82WaNYu1hGC785Q' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/payout/accounts/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@deleteAccount',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@deleteAccount',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::G82WaNYu1hGC785Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2Cr4Ek4nYimpx4mp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/payout/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@transactions',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@transactions',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::2Cr4Ek4nYimpx4mp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HRgDb1e3ntxOcluc' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payout/request',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@requestPayout',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@requestPayout',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::HRgDb1e3ntxOcluc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OiZKBowQ8OK9GBDV' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payout/{payout}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student,tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@cancelPayout',
        'controller' => 'App\\Http\\Controllers\\Api\\Payout\\PayoutController@cancelPayout',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::OiZKBowQ8OK9GBDV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oXdJrOZDUdq0zXuB' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@store',
        'controller' => 'App\\Http\\Controllers\\BookingController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::oXdJrOZDUdq0zXuB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6v72GFjx2B0o6MIi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/bookings/{booking}/review',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Review\\ReviewController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Review\\ReviewController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::6v72GFjx2B0o6MIi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4yQfWmTX6EM6CdRX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor/bookings/requests',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@pendingRequests',
        'controller' => 'App\\Http\\Controllers\\BookingController@pendingRequests',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::4yQfWmTX6EM6CdRX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lG4ur6xlKoS6T5m7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/bookings/{booking}/accept',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@accept',
        'controller' => 'App\\Http\\Controllers\\BookingController@accept',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::lG4ur6xlKoS6T5m7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xlUT7FUEghIk21eL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/bookings/{booking}/decline',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@decline',
        'controller' => 'App\\Http\\Controllers\\BookingController@decline',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::xlUT7FUEghIk21eL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8uM4ymxZyARBOB1V' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@index',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::8uM4ymxZyARBOB1V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oquVbrRSMPIg2XJn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@store',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::oquVbrRSMPIg2XJn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::65pePsiQYc2jq8lw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor/availability/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@bulkStore',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@bulkStore',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::65pePsiQYc2jq8lw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lW0DYS2SKD45DouF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor/availability/replace',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@replaceAll',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@replaceAll',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::lW0DYS2SKD45DouF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::19mhSjtGZqSH66x4' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/tutor/availability/{slot}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@update',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::19mhSjtGZqSH66x4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::F05a5YJsg8TgiP7P' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'api/tutor/availability/{slot}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@toggle',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@toggle',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::F05a5YJsg8TgiP7P',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wuLgWsL6C2o7QwSE' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor/availability/{slot}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\AvailabilityController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/tutor/availability',
        'where' => 
        array (
        ),
        'as' => 'generated::wuLgWsL6C2o7QwSE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sGAMCJzBS7D6OJKl' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutors/{tutorId}/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@publicSlots',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@publicSlots',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::sGAMCJzBS7D6OJKl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::SnSAS5RFRE770GfS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor/tier/progress',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\TierController@myProgress',
        'controller' => 'App\\Http\\Controllers\\TierController@myProgress',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::SnSAS5RFRE770GfS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mmtMExAkHu2CXci1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\DiscoverController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\DiscoverController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::mmtMExAkHu2CXci1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LamwvRSssHNlpg1z' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutors/{tutor}/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Review\\ReviewController@tutorReviews',
        'controller' => 'App\\Http\\Controllers\\Api\\Review\\ReviewController@tutorReviews',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::LamwvRSssHNlpg1z',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ivZ1CAxzsNB6hpyt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutors/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Tutor\\DiscoverController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Tutor\\DiscoverController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ivZ1CAxzsNB6hpyt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GPLdhKahjG6NqYFP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/bookings/{booking}/dispute',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BookingController@resolveDispute',
        'controller' => 'App\\Http\\Controllers\\BookingController@resolveDispute',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::GPLdhKahjG6NqYFP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZQ2iTEb5PWhSEjV1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/kyc/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@stats',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@stats',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZQ2iTEb5PWhSEjV1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LGIUTi9AgVd8gSoH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/kyc/applications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@index',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::LGIUTi9AgVd8gSoH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oCHZ7tn4ovLb4vPP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/kyc/applications/{application}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@show',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::oCHZ7tn4ovLb4vPP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XbG68bpdbLg6fGT1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/kyc/applications/{application}/flag',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@flag',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@flag',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::XbG68bpdbLg6fGT1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZtoqcGjpSWUv2uQ4' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/kyc/applications/{application}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@approve',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@approve',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZtoqcGjpSWUv2uQ4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WyOLfKbsmze6C9zk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/kyc/applications/{application}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@reject',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@reject',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::WyOLfKbsmze6C9zk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1AErk2UhgWTYqT16' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/kyc/documents/{document}/url',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminKycController@documentUrl',
        'controller' => 'App\\Http\\Controllers\\AdminKycController@documentUrl',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::1AErk2UhgWTYqT16',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::g8kpEVWYsUnTq3Xs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/tiers/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@stats',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@stats',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::g8kpEVWYsUnTq3Xs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6aOCEl81zVF3otsE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/tiers/commission-preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@commissionPreview',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@commissionPreview',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::6aOCEl81zVF3otsE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CknH022DROzDivnT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/tiers/re-evaluate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@reEvaluate',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@reEvaluate',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::CknH022DROzDivnT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::meYey23jT8rwtJAN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/tiers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@index',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::meYey23jT8rwtJAN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jbgP8TUR0rEVpfLr' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/tiers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@store',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::jbgP8TUR0rEVpfLr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kY3wRTR5d45K9E6e' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/tiers/{tier}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@show',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::kY3wRTR5d45K9E6e',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UeZ6EgwsHDK3DR0v' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/admin/tiers/{tier}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@update',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::UeZ6EgwsHDK3DR0v',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oZzH92DBGTKylLT9' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/tiers/{tier}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@destroy',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::oZzH92DBGTKylLT9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vC3BybTo7fKNm0Ex' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/tiers/{tier}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@toggle',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@toggle',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::vC3BybTo7fKNm0Ex',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zlnYs1HCB0zGnQ3n' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/tiers/{tier}/assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminTierController@assign',
        'controller' => 'App\\Http\\Controllers\\AdminTierController@assign',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::zlnYs1HCB0zGnQ3n',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::G1jJusCBregvUuow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@show',
        'controller' => 'App\\Http\\Controllers\\SessionController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::G1jJusCBregvUuow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jjlKhnZ1PDUMMw1S' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/bookings/{booking}/session',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@showByBooking',
        'controller' => 'App\\Http\\Controllers\\SessionController@showByBooking',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::jjlKhnZ1PDUMMw1S',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZWwDvrgidiP3IWQO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/invoices/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Invoice\\InvoiceController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Invoice\\InvoiceController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZWwDvrgidiP3IWQO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.invoices.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/invoices/{invoice}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'signed',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@download',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@download',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'api.invoices.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kobskE1IJTolJX6O' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/join',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@join',
        'controller' => 'App\\Http\\Controllers\\SessionController@join',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::kobskE1IJTolJX6O',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5YLI2nJA6MZSn7f5' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/token/refresh',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@refreshToken',
        'controller' => 'App\\Http\\Controllers\\SessionController@refreshToken',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::5YLI2nJA6MZSn7f5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::k7eQM5EmgjvOAjKw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/keepalive',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@keepalive',
        'controller' => 'App\\Http\\Controllers\\SessionController@keepalive',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::k7eQM5EmgjvOAjKw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7pLTxBds4Sx7sLTA' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
          3 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@start',
        'controller' => 'App\\Http\\Controllers\\SessionController@start',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::7pLTxBds4Sx7sLTA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZxPSGLjrSusC1H6C' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/end',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\SessionController@end',
        'controller' => 'App\\Http\\Controllers\\SessionController@end',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZxPSGLjrSusC1H6C',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FX1SWa8KWEBWj9GB' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Report\\ReportController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Report\\ReportController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::FX1SWa8KWEBWj9GB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::j0D7eVvrJgjdNuKp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sessions/{session}/chat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ChatController@index',
        'controller' => 'App\\Http\\Controllers\\ChatController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::j0D7eVvrJgjdNuKp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dZK0nEt63Jz12V9v' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/chat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ChatController@store',
        'controller' => 'App\\Http\\Controllers\\ChatController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::dZK0nEt63Jz12V9v',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kgjS2myH2o0utPWy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/chat/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ChatController@markRead',
        'controller' => 'App\\Http\\Controllers\\ChatController@markRead',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::kgjS2myH2o0utPWy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fLGEjOGQkQGRmXM2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sessions/{session}/chat/unread',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ChatController@unreadCount',
        'controller' => 'App\\Http\\Controllers\\ChatController@unreadCount',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::fLGEjOGQkQGRmXM2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2gXb5O9NTlZ0PTfe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sessions/{session}/polls',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\PollController@index',
        'controller' => 'App\\Http\\Controllers\\PollController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::2gXb5O9NTlZ0PTfe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZJ9Xb1DZavzZprha' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/polls',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\PollController@store',
        'controller' => 'App\\Http\\Controllers\\PollController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZJ9Xb1DZavzZprha',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eC56SjcHWWYk7ZXG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sessions/{session}/polls/{poll}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\PollController@show',
        'controller' => 'App\\Http\\Controllers\\PollController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::eC56SjcHWWYk7ZXG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CYaCPZiUfSw6HHdT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/polls/{poll}/respond',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\PollController@respond',
        'controller' => 'App\\Http\\Controllers\\PollController@respond',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::CYaCPZiUfSw6HHdT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DOIuuSW7OA8C994m' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sessions/{session}/polls/{poll}/close',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\PollController@close',
        'controller' => 'App\\Http\\Controllers\\PollController@close',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::DOIuuSW7OA8C994m',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Hq0MpmAPmiQxMau5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/kyc/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\KycController@status',
        'controller' => 'App\\Http\\Controllers\\KycController@status',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::Hq0MpmAPmiQxMau5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3MvBp183f7JHyjlD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/kyc/apply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\KycController@apply',
        'controller' => 'App\\Http\\Controllers\\KycController@apply',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::3MvBp183f7JHyjlD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PB55pK4QFAAj3nOi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/kyc/documents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\KycController@uploadDocument',
        'controller' => 'App\\Http\\Controllers\\KycController@uploadDocument',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::PB55pK4QFAAj3nOi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Fi53LddPCYxt8ive' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/kyc/documents/{document}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\KycController@deleteDocument',
        'controller' => 'App\\Http\\Controllers\\KycController@deleteDocument',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::Fi53LddPCYxt8ive',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JsSaIqVnPrnalY7h' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:823:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'C:\\\\teachmeapp-laravel\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000006690000000000000000";}}',
        'as' => 'generated::JsSaIqVnPrnalY7h',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:25:"fn () => \\inertia(\'Home\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004bd0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'how-it-works' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'how-it-works',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:31:"fn () => \\inertia(\'HowItWorks\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004bf0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'how-it-works',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pricing' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'pricing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:28:"fn () => \\inertia(\'Pricing\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004c10000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'pricing',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showLogin',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showLogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@login',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.post',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showRegister',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showRegister',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@register',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@register',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register.post',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showForgotPassword',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showForgotPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@sendResetLink',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@sendResetLink',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showResetPassword',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@showResetPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@resetPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'legal.privacy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'legal/privacy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Legal\\LegalController@privacy',
        'controller' => 'App\\Http\\Controllers\\Legal\\LegalController@privacy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'legal.privacy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'legal.terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'legal/terms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Legal\\LegalController@terms',
        'controller' => 'App\\Http\\Controllers\\Legal\\LegalController@terms',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'legal.terms',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'consent.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'consent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Legal\\ConsentController@show',
        'controller' => 'App\\Http\\Controllers\\Legal\\ConsentController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'consent.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'consent.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'consent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Legal\\ConsentController@store',
        'controller' => 'App\\Http\\Controllers\\Legal\\ConsentController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'consent.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.notice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@verificationNotice',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@verificationNotice',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.notice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@logout',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sessions.chat.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sessions/{session}/chat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'auth:sanctum',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ChatController@store',
        'controller' => 'App\\Http\\Controllers\\ChatController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sessions.chat.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/verify/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'signed',
          3 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@verificationVerify',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@verificationVerify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/verification-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuthWebController@verificationResend',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuthWebController@verificationResend',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@index',
        'as' => 'admin.dashboard',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@index',
        'as' => 'admin.users.index',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@show',
        'as' => 'admin.users.show',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.suspend' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users/{user}/suspend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@suspend',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@suspend',
        'as' => 'admin.users.suspend',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.ban' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users/{user}/ban',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@ban',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@ban',
        'as' => 'admin.users.ban',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.activate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users/{user}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@activate',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@activate',
        'as' => 'admin.users.activate',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.update-password' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users/{user}/update-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@updatePassword',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@updatePassword',
        'as' => 'admin.users.update-password',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.send-reset-link' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users/{user}/send-reset-link',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@sendPasswordResetLink',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@sendPasswordResetLink',
        'as' => 'admin.users.send-reset-link',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.institutions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/institutions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\InstitutionController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\InstitutionController@index',
        'as' => 'admin.institutions.index',
        'namespace' => NULL,
        'prefix' => 'admin/institutions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.institutions.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/institutions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\InstitutionController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\InstitutionController@store',
        'as' => 'admin.institutions.store',
        'namespace' => NULL,
        'prefix' => 'admin/institutions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.institutions.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/institutions/{institution}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\InstitutionController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\InstitutionController@update',
        'as' => 'admin.institutions.update',
        'namespace' => NULL,
        'prefix' => 'admin/institutions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.institutions.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/institutions/{institution}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\InstitutionController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\InstitutionController@destroy',
        'as' => 'admin.institutions.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/institutions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.subjects.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SubjectController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\SubjectController@index',
        'as' => 'admin.subjects.index',
        'namespace' => NULL,
        'prefix' => 'admin/subjects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.subjects.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SubjectController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\SubjectController@store',
        'as' => 'admin.subjects.store',
        'namespace' => NULL,
        'prefix' => 'admin/subjects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.subjects.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/subjects/{subject}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SubjectController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\SubjectController@update',
        'as' => 'admin.subjects.update',
        'namespace' => NULL,
        'prefix' => 'admin/subjects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.subjects.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/subjects/{subject}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SubjectController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\SubjectController@destroy',
        'as' => 'admin.subjects.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/subjects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.kyc.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/kyc',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@index',
        'as' => 'admin.kyc.index',
        'namespace' => NULL,
        'prefix' => 'admin/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.kyc.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/kyc/{application}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@show',
        'as' => 'admin.kyc.show',
        'namespace' => NULL,
        'prefix' => 'admin/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.kyc.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/kyc/{application}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@approve',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@approve',
        'as' => 'admin.kyc.approve',
        'namespace' => NULL,
        'prefix' => 'admin/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.kyc.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/kyc/{application}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@reject',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminKycWebController@reject',
        'as' => 'admin.kyc.reject',
        'namespace' => NULL,
        'prefix' => 'admin/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sessions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SessionMonitorController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\SessionMonitorController@index',
        'as' => 'admin.sessions.index',
        'namespace' => NULL,
        'prefix' => 'admin/sessions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sessions.force-end' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/sessions/{session}/force-end',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SessionMonitorController@forceEnd',
        'controller' => 'App\\Http\\Controllers\\Admin\\SessionMonitorController@forceEnd',
        'as' => 'admin.sessions.force-end',
        'namespace' => NULL,
        'prefix' => 'admin/sessions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payouts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/payouts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@index',
        'as' => 'admin.payouts.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payouts.processing' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/payouts/{payout}/processing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@markProcessing',
        'controller' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@markProcessing',
        'as' => 'admin.payouts.processing',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payouts.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/payouts/{payout}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@markCompleted',
        'controller' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@markCompleted',
        'as' => 'admin.payouts.complete',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payouts.fail' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/payouts/{payout}/fail',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@markFailed',
        'controller' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@markFailed',
        'as' => 'admin.payouts.fail',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payout-accounts.verify' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/payout-accounts/{account}/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@verifyAccount',
        'controller' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@verifyAccount',
        'as' => 'admin.payout-accounts.verify',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payout-accounts.unverify' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/payout-accounts/{account}/unverify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@unverifyAccount',
        'controller' => 'App\\Http\\Controllers\\Admin\\PayoutWebController@unverifyAccount',
        'as' => 'admin.payout-accounts.unverify',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.gateways.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/gateways',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@index',
        'as' => 'admin.gateways.index',
        'namespace' => NULL,
        'prefix' => 'admin/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.gateways.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/gateways/{method}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@show',
        'as' => 'admin.gateways.show',
        'namespace' => NULL,
        'prefix' => 'admin/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.gateways.configure' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/gateways/{method}/configure',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@configure',
        'controller' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@configure',
        'as' => 'admin.gateways.configure',
        'namespace' => NULL,
        'prefix' => 'admin/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.gateways.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/gateways/{method}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@toggle',
        'controller' => 'App\\Http\\Controllers\\Admin\\GatewayWebController@toggle',
        'as' => 'admin.gateways.toggle',
        'namespace' => NULL,
        'prefix' => 'admin/gateways',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tiers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@index',
        'as' => 'admin.tiers.index',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tiers/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@create',
        'as' => 'admin.tiers.create',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/tiers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@store',
        'as' => 'admin.tiers.store',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tiers/{tier}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@edit',
        'as' => 'admin.tiers.edit',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/tiers/{tier}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@update',
        'as' => 'admin.tiers.update',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/tiers/{tier}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@destroy',
        'as' => 'admin.tiers.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tiers.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/tiers/{tier}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\TierWebController@toggle',
        'controller' => 'App\\Http\\Controllers\\Admin\\TierWebController@toggle',
        'as' => 'admin.tiers.toggle',
        'namespace' => NULL,
        'prefix' => 'admin/tiers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.settings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SettingsWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\SettingsWebController@index',
        'as' => 'admin.settings.index',
        'namespace' => NULL,
        'prefix' => 'admin/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.settings.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/settings/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SettingsWebController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\SettingsWebController@update',
        'as' => 'admin.settings.update',
        'namespace' => NULL,
        'prefix' => 'admin/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingWebController@index',
        'as' => 'admin.bookings.index',
        'namespace' => NULL,
        'prefix' => 'admin/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookings.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/bookings/{booking}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingWebController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingWebController@show',
        'as' => 'admin.bookings.show',
        'namespace' => NULL,
        'prefix' => 'admin/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookings.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/bookings/{booking}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingWebController@cancel',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingWebController@cancel',
        'as' => 'admin.bookings.cancel',
        'namespace' => NULL,
        'prefix' => 'admin/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookings.resolve-dispute' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/bookings/{booking}/resolve-dispute',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingWebController@resolveDispute',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingWebController@resolveDispute',
        'as' => 'admin.bookings.resolve-dispute',
        'namespace' => NULL,
        'prefix' => 'admin/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.financials.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/financials',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\FinancialReportController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\FinancialReportController@index',
        'as' => 'admin.financials.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.audit.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/audit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AuditLogController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AuditLogController@index',
        'as' => 'admin.audit.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notifications.broadcast' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/notifications/broadcast',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BroadcastNotificationController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\BroadcastNotificationController@index',
        'as' => 'admin.notifications.broadcast',
        'namespace' => NULL,
        'prefix' => 'admin/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notifications.broadcast.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/notifications/broadcast',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BroadcastNotificationController@send',
        'controller' => 'App\\Http\\Controllers\\Admin\\BroadcastNotificationController@send',
        'as' => 'admin.notifications.broadcast.send',
        'namespace' => NULL,
        'prefix' => 'admin/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notifications.broadcast.search-users' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/notifications/broadcast/search-users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\BroadcastNotificationController@searchUsers',
        'controller' => 'App\\Http\\Controllers\\Admin\\BroadcastNotificationController@searchUsers',
        'as' => 'admin.notifications.broadcast.search-users',
        'namespace' => NULL,
        'prefix' => 'admin/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reviews.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@index',
        'as' => 'admin.reviews.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reviews.hide' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'admin/reviews/{review}/hide',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@hide',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@hide',
        'as' => 'admin.reviews.hide',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reviews.restore' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'admin/reviews/{review}/restore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@restore',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@restore',
        'as' => 'admin.reviews.restore',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reviews.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/reviews/{review}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReviewController@destroy',
        'as' => 'admin.reviews.destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReportWebController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReportWebController@index',
        'as' => 'admin.reports.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.under-review' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'admin/reports/{report}/under-review',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReportWebController@markUnderReview',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReportWebController@markUnderReview',
        'as' => 'admin.reports.under-review',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.warn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/reports/{report}/warn',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReportWebController@warn',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReportWebController@warn',
        'as' => 'admin.reports.warn',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.suspend' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/reports/{report}/suspend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReportWebController@suspend',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReportWebController@suspend',
        'as' => 'admin.reports.suspend',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.dismiss' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/reports/{report}/dismiss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReportWebController@dismiss',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReportWebController@dismiss',
        'as' => 'admin.reports.dismiss',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorDashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorDashboardController@index',
        'as' => 'tutor.dashboard',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorProfileController@edit',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorProfileController@edit',
        'as' => 'tutor.profile.edit',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorProfileController@update',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorProfileController@update',
        'as' => 'tutor.profile.update',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.avatar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/profile/avatar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorProfileController@uploadAvatar',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorProfileController@uploadAvatar',
        'as' => 'tutor.profile.avatar',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@index',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@index',
        'as' => 'tutor.availability.index',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@store',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@store',
        'as' => 'tutor.availability.store',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.bulk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/availability/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@bulkStore',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@bulkStore',
        'as' => 'tutor.availability.bulk',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.replace' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/availability/replace',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@replaceAll',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@replaceAll',
        'as' => 'tutor.availability.replace',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'tutor/availability/{slot}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@update',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@update',
        'as' => 'tutor.availability.update',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'tutor/availability/{slot}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@toggle',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@toggle',
        'as' => 'tutor.availability.toggle',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.availability.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'tutor/availability/{slot}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@destroy',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorAvailabilityController@destroy',
        'as' => 'tutor.availability.destroy',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@index',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@index',
        'as' => 'tutor.bookings.index',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.requests' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings/requests',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@requests',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@requests',
        'as' => 'tutor.bookings.requests',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings/{booking}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@show',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@show',
        'as' => 'tutor.bookings.show',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.accept' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/bookings/{booking}/accept',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@accept',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@accept',
        'as' => 'tutor.bookings.accept',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.decline' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/bookings/{booking}/decline',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@decline',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@decline',
        'as' => 'tutor.bookings.decline',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/bookings/{booking}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@cancel',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorBookingController@cancel',
        'as' => 'tutor.bookings.cancel',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.sessions.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorSessionController@show',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorSessionController@show',
        'as' => 'tutor.sessions.show',
        'namespace' => NULL,
        'prefix' => 'tutor/sessions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.sessions.start' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/sessions/{session}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorSessionController@start',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorSessionController@start',
        'as' => 'tutor.sessions.start',
        'namespace' => NULL,
        'prefix' => 'tutor/sessions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.sessions.end' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/sessions/{session}/end',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorSessionController@end',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorSessionController@end',
        'as' => 'tutor.sessions.end',
        'namespace' => NULL,
        'prefix' => 'tutor/sessions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/wallet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@index',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@index',
        'as' => 'tutor.wallet.index',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.payouts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/wallet/payouts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@payouts',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@payouts',
        'as' => 'tutor.wallet.payouts',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.payout.request' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/wallet/payout/request',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@requestPayout',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@requestPayout',
        'as' => 'tutor.wallet.payout.request',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.payout.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/wallet/payout/{payout}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@cancelPayout',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@cancelPayout',
        'as' => 'tutor.wallet.payout.cancel',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.payout-account.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/wallet/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@savePayoutAccount',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@savePayoutAccount',
        'as' => 'tutor.wallet.payout-account.store',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.payout-account.default' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/wallet/accounts/{account}/default',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@setDefaultAccount',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@setDefaultAccount',
        'as' => 'tutor.wallet.payout-account.default',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.wallet.payout-account.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'tutor/wallet/accounts/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@deletePayoutAccount',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorWalletController@deletePayoutAccount',
        'as' => 'tutor.wallet.payout-account.delete',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.kyc.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/kyc',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@index',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@index',
        'as' => 'tutor.kyc.index',
        'namespace' => NULL,
        'prefix' => 'tutor/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.kyc.apply' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/kyc/apply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@apply',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@apply',
        'as' => 'tutor.kyc.apply',
        'namespace' => NULL,
        'prefix' => 'tutor/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.kyc.upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/kyc/documents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@upload',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@upload',
        'as' => 'tutor.kyc.upload',
        'namespace' => NULL,
        'prefix' => 'tutor/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.kyc.document.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'tutor/kyc/documents/{document}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:tutor',
        ),
        'uses' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@deleteDocument',
        'controller' => 'App\\Http\\Controllers\\Tutor\\TutorKycController@deleteDocument',
        'as' => 'tutor.kyc.document.destroy',
        'namespace' => NULL,
        'prefix' => 'tutor/kyc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentDashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentDashboardController@index',
        'as' => 'student.dashboard',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.discover' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/discover',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentDiscoverController@index',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentDiscoverController@index',
        'as' => 'student.discover',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.tutor.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/tutors/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentDiscoverController@profile',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentDiscoverController@profile',
        'as' => 'student.tutor.profile',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.institutions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/institutions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\InstitutionController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\InstitutionController@index',
        'as' => 'student.institutions.index',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.subjects.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SubjectController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\SubjectController@index',
        'as' => 'student.subjects.index',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@index',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@index',
        'as' => 'student.bookings.index',
        'namespace' => NULL,
        'prefix' => 'student/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/bookings/create/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@create',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@create',
        'as' => 'student.bookings.create',
        'namespace' => NULL,
        'prefix' => 'student/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@store',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@store',
        'as' => 'student.bookings.store',
        'namespace' => NULL,
        'prefix' => 'student/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/bookings/{booking}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@show',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@show',
        'as' => 'student.bookings.show',
        'namespace' => NULL,
        'prefix' => 'student/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/bookings/{booking}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@cancel',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@cancel',
        'as' => 'student.bookings.cancel',
        'namespace' => NULL,
        'prefix' => 'student/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings.review' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/bookings/{booking}/review',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\ReviewController@store',
        'controller' => 'App\\Http\\Controllers\\ReviewController@store',
        'as' => 'student.bookings.review',
        'namespace' => NULL,
        'prefix' => 'student/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.session.join' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@joinSession',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@joinSession',
        'as' => 'student.session.join',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.session.end' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/sessions/{session}/end',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentBookingController@endSession',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentBookingController@endSession',
        'as' => 'student.session.end',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.wallet.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/wallet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentWalletController@index',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentWalletController@index',
        'as' => 'student.wallet.index',
        'namespace' => NULL,
        'prefix' => 'student/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.wallet.deposit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/wallet/deposit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentWalletController@deposit',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentWalletController@deposit',
        'as' => 'student.wallet.deposit',
        'namespace' => NULL,
        'prefix' => 'student/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.wallet.gateway-redirect' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/wallet/gateway-redirect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentWalletController@gatewayRedirect',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentWalletController@gatewayRedirect',
        'as' => 'student.wallet.gateway-redirect',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.guardians.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/guardians',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\GuardianController@index',
        'controller' => 'App\\Http\\Controllers\\GuardianController@index',
        'as' => 'student.guardians.index',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.guardians.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/guardians',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\GuardianController@store',
        'controller' => 'App\\Http\\Controllers\\GuardianController@store',
        'as' => 'student.guardians.store',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.guardians.update' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'student/guardians/{guardian}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\GuardianController@update',
        'controller' => 'App\\Http\\Controllers\\GuardianController@update',
        'as' => 'student.guardians.update',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.guardians.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'student/guardians/{guardian}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\GuardianController@destroy',
        'controller' => 'App\\Http\\Controllers\\GuardianController@destroy',
        'as' => 'student.guardians.destroy',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentProfileController@edit',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentProfileController@edit',
        'as' => 'student.profile.edit',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentProfileController@update',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentProfileController@update',
        'as' => 'student.profile.update',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile.avatar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'student/profile/avatar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'role:student',
        ),
        'uses' => 'App\\Http\\Controllers\\Student\\StudentProfileController@uploadAvatar',
        'controller' => 'App\\Http\\Controllers\\Student\\StudentProfileController@uploadAvatar',
        'as' => 'student.profile.avatar',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@show',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
          4 => 'signed',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@download',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@download',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutors.reviews' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutors/{tutor}/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ReviewController@tutorReviews',
        'controller' => 'App\\Http\\Controllers\\ReviewController@tutorReviews',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutors.reviews',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sessions.report' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sessions/{session}/report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@store',
        'controller' => 'App\\Http\\Controllers\\ReportController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sessions.report',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.notifications.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationPreferenceController@index',
        'controller' => 'App\\Http\\Controllers\\NotificationPreferenceController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.notifications.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.notifications.update' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'settings/notifications/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationPreferenceController@update',
        'controller' => 'App\\Http\\Controllers\\NotificationPreferenceController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.notifications.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.notifications.bulk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings/notifications/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationPreferenceController@bulkUpdate',
        'controller' => 'App\\Http\\Controllers\\NotificationPreferenceController@bulkUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.notifications.bulk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.notifications.reset' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'settings/notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationPreferenceController@reset',
        'controller' => 'App\\Http\\Controllers\\NotificationPreferenceController@reset',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.notifications.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notifications/{id}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.read-all' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notifications/read-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'verified',
          3 => 'check.account.status',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAllRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAllRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.read-all',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::M0CjrEwIyGGLypr2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'broadcasting/auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'controller' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
        'as' => 'generated::M0CjrEwIyGGLypr2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.public' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:6:"public";s:6:"config";a:7:{s:6:"driver";s:5:"local";s:4:"root";s:40:"C:\\teachmeapp-laravel\\storage\\app/public";s:3:"url";s:24:"http://localhost/storage";s:10:"visibility";s:6:"public";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"000000000000055c0000000000000000";}}',
        'as' => 'storage.public',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.public.upload' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:6:"public";s:6:"config";a:7:{s:6:"driver";s:5:"local";s:4:"root";s:40:"C:\\teachmeapp-laravel\\storage\\app/public";s:3:"url";s:24:"http://localhost/storage";s:10:"visibility";s:6:"public";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:325:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ReceiveFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000005590000000000000000";}}',
        'as' => 'storage.public.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
