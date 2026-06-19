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
            '_route' => 'auth.generated::LSKbyWjdjBDssc2y',
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
            '_route' => 'generated::LjqWgEpMPc4tpUDS',
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
            '_route' => 'generated::PfGsxYizfd8VYLkv',
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
            '_route' => 'generated::3CPneT8KRoL41QdA',
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
            '_route' => 'generated::DcfHqdEDYZsIX8LG',
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
            '_route' => 'generated::m0HXP0Jq2uZj5hqI',
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
            '_route' => 'generated::Ay46qzfzNRAfk1xE',
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
      '/api/tutor/bookings/requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5DFqdKuHHwU3lEp5',
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
      '/api/tutor/tier/progress' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::a8Jtd6testzalfwX',
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
            '_route' => 'generated::EImmIILT7NTQYD4d',
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
            '_route' => 'generated::9txga54wEotyerSe',
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
            '_route' => 'generated::K1WMLlLFb4e2pWoY',
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
            '_route' => 'generated::ET6YKOP8RXKSY5it',
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
            '_route' => 'generated::SniAJMIwiL6PMe4s',
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
            '_route' => 'generated::YluIjEQsaGcRNHUA',
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
            '_route' => 'generated::Kug7QFiUQp9AWVGD',
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
            '_route' => 'generated::Hmguj6VZlthQjtvC',
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
            '_route' => 'generated::RcNXqjISgD8RZiiN',
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
            '_route' => 'generated::teKeJZuAGpSDl0EI',
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
            '_route' => 'generated::yYdKCFnMes90ggco',
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
            '_route' => 'generated::UE54Js6v7N5ntavJ',
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
      0 => '{^(?|/a(?|pi/(?|payment/(?|webhook/([^/]++)(*:45)|callback/([^/]++)(*:69)|booking/([^/]++)(*:92))|t(?|iers/([^/]++)(*:117)|utors/([^/]++)/availability(*:152))|email/verify/([^/]++)/([^/]++)(*:191)|admin/(?|payment/gateways/([^/]++)(?|(*:236)|/(?|configure(*:257)|t(?|oggle(*:274)|est(*:285))))|bookings/([^/]++)/dispute(*:321)|kyc/(?|applications/([^/]++)(?|(*:360)|/(?|flag(*:376)|approve(*:391)|reject(*:405)))|documents/([^/]++)/url(*:437))|tiers/([^/]++)(?|(*:463)|/(?|toggle(*:481)|assign(*:495))))|bookings/([^/]++)(?|(*:526)|/(?|cancel(*:544)|accept(*:558)|decline(*:573)|session(*:588)))|sessions/([^/]++)(?|(*:618)|/(?|join(*:634)|token/refresh(*:655)|keepalive(*:672)|start(*:685)|end(*:696)|chat(?|(*:711)|/(?|read(*:727)|unread(*:741)))|polls(?|(*:759)|/([^/]++)(?|(*:779)|/(?|respond(*:798)|close(*:811))))))|kyc/documents/([^/]++)(*:846))|dmin/(?|users/([^/]++)(?|(*:880)|/(?|s(?|uspend(*:902)|end\\-reset\\-link(*:926))|ban(*:938)|activate(*:954)|update\\-password(*:978)))|institutions/([^/]++)(?|(*:1012))|s(?|ubjects/([^/]++)(?|(*:1045))|essions/([^/]++)/force\\-end(*:1082))|kyc/([^/]++)(?|(*:1107)|/(?|approve(*:1127)|reject(*:1142)))|payout(?|s/([^/]++)/(?|processing(*:1186)|complete(*:1203)|fail(*:1216))|\\-accounts/([^/]++)/(?|verify(*:1255)|unverify(*:1272)))|gateways/([^/]++)(?|(*:1303)|/(?|configure(*:1325)|toggle(*:1340)))|tiers/([^/]++)(?|/(?|edit(*:1376)|toggle(*:1391))|(*:1401))|bookings/([^/]++)(?|(*:1431)|/(?|cancel(*:1450)|resolve\\-dispute(*:1475)))|re(?|views/([^/]++)(?|/(?|hide(*:1516)|restore(*:1532))|(*:1542))|ports/([^/]++)/(?|under\\-review(*:1583)|warn(*:1596)|suspend(*:1612)|dismiss(*:1628)))))|/reset\\-password/([^/]++)(*:1666)|/s(?|e(?|ssions/([^/]++)/(?|chat(*:1707)|report(*:1722))|ttings/notifications/(?|([^/]++)(*:1764)|bulk(*:1777)))|t(?|udent/(?|tutors/([^/]++)(*:1816)|bookings/(?|create/([^/]++)(*:1852)|([^/]++)(?|(*:1872)|/(?|cancel(*:1891)|review(*:1906))))|sessions/([^/]++)(?|(*:1938)|/end(*:1951))|guardians/([^/]++)(?|(*:1982)))|orage/(.*)(?|(*:2006))))|/email/verify/([^/]++)/([^/]++)(*:2049)|/tutor(?|/(?|availability/([^/]++)(?|(*:2095)|/toggle(*:2111)|(*:2120))|bookings/([^/]++)(?|(*:2150)|/(?|accept(*:2169)|decline(*:2185)|cancel(*:2200)))|sessions/([^/]++)(?|(*:2231)|/(?|start(*:2249)|end(*:2261)))|wallet/(?|payout/([^/]++)/cancel(*:2304)|accounts/([^/]++)(?|/default(*:2341)|(*:2350)))|kyc/documents/([^/]++)(*:2383))|s/([^/]++)/reviews(*:2411))|/invoices/([^/]++)(?|(*:2442)|/download(*:2460))|/notifications/([^/]++)/read(*:2498))/?$}sDu',
    ),
    3 => 
    array (
      45 => 
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
      69 => 
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
      92 => 
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
      117 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TtkzrjRPAD93mMMr',
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
      152 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ptc9mEb8lmcIbp4m',
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
      191 => 
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
      236 => 
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
      257 => 
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
      274 => 
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
      285 => 
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
      321 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uB6msWhfNda2oaZM',
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
      360 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IS0oUwaFkcagjiEa',
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
      376 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Cfuvqi6nlhQTHjN9',
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
      391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cHugLyxhHHKdJ8ec',
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
      405 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::76TpaAI5a86iBQe3',
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
      437 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::S2FAw5D2gy3JpJ6a',
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
      463 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kgymLUxOY3x03yfE',
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
            '_route' => 'generated::oRBOLPZBZ5ghFpQW',
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
            '_route' => 'generated::WifXfL0st7UEU1AZ',
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
      481 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3NzqvDz8BvieSyWt',
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
      495 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1XjUXWWMtajQ0De9',
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
      526 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4frGog8ylKOKuwI2',
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
      544 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::C917dDF70AvidDrt',
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
      558 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qqNFFr5sYbQRdfy4',
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
      573 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FeUcR6u3dPz0aPPj',
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
      588 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EaVuSVm5AOqLthVt',
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
      618 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vQr90gKa0aDWem9N',
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
      634 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UDRu0ZU5UGKvIfbu',
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
      655 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::M246aPGXA9dfLqtr',
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
      672 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nHiuTJqyoZQrL5GA',
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
      685 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Mb9qV5SmmnHGLghV',
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
      696 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gPE8YuCn6ej8RFHy',
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
      711 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KMxgClwsF0Qc5Nw5',
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
            '_route' => 'generated::203QdDuXU71GxYDf',
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
      727 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CLQrm6o8kNxYSkeb',
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
      741 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FsLEvhwfCd1nmMQv',
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
      759 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CMs9AARsRVOCYSc9',
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
            '_route' => 'generated::XwrDiJ8r5eHYOW8k',
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
      779 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TedKBRm5EphcC4FJ',
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
      798 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::38dEgfDCzafw05bT',
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
      811 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8JcnJVBEhYUHYXkg',
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
      846 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2BO3eQuF66l2iMHB',
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
      880 => 
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
      902 => 
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
      926 => 
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
      938 => 
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
      954 => 
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
      978 => 
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
      1012 => 
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
      1045 => 
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
      1082 => 
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
      1107 => 
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
      1127 => 
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
      1142 => 
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
      1186 => 
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
      1203 => 
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
      1216 => 
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
      1255 => 
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
      1272 => 
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
      1303 => 
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
      1325 => 
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
      1340 => 
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
      1376 => 
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
      1391 => 
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
      1401 => 
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
      1431 => 
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
      1450 => 
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
      1475 => 
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
      1516 => 
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
      1532 => 
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
      1542 => 
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
      1583 => 
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
      1596 => 
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
      1612 => 
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
      1628 => 
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
      1666 => 
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
      1707 => 
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
      1722 => 
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
      1764 => 
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
      1777 => 
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
      1816 => 
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
      1852 => 
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
      1872 => 
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
      1891 => 
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
      1906 => 
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
      1938 => 
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
      1951 => 
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
      1982 => 
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
      2006 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local',
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
            '_route' => 'storage.local.upload',
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
      2049 => 
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
      2095 => 
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
      2111 => 
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
      2120 => 
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
      2150 => 
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
      2169 => 
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
      2185 => 
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
      2200 => 
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
      2231 => 
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
      2249 => 
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
      2261 => 
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
      2304 => 
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
      2341 => 
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
      2350 => 
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
      2383 => 
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
      2411 => 
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
      2442 => 
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
      2460 => 
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
      2498 => 
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
    'auth.generated::LSKbyWjdjBDssc2y' => 
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
        'as' => 'auth.generated::LSKbyWjdjBDssc2y',
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
    'generated::LjqWgEpMPc4tpUDS' => 
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
        'as' => 'generated::LjqWgEpMPc4tpUDS',
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
    'generated::TtkzrjRPAD93mMMr' => 
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
        'as' => 'generated::TtkzrjRPAD93mMMr',
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
    'generated::PfGsxYizfd8VYLkv' => 
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
        'as' => 'generated::PfGsxYizfd8VYLkv',
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
    'generated::3CPneT8KRoL41QdA' => 
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
        'as' => 'generated::3CPneT8KRoL41QdA',
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
    'generated::DcfHqdEDYZsIX8LG' => 
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
        'as' => 'generated::DcfHqdEDYZsIX8LG',
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
    'generated::4frGog8ylKOKuwI2' => 
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
        'as' => 'generated::4frGog8ylKOKuwI2',
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
    'generated::Ay46qzfzNRAfk1xE' => 
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
        'as' => 'generated::Ay46qzfzNRAfk1xE',
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
    'generated::C917dDF70AvidDrt' => 
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
        'as' => 'generated::C917dDF70AvidDrt',
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
    'generated::m0HXP0Jq2uZj5hqI' => 
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
        'as' => 'generated::m0HXP0Jq2uZj5hqI',
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
    'generated::5DFqdKuHHwU3lEp5' => 
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
        'as' => 'generated::5DFqdKuHHwU3lEp5',
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
    'generated::qqNFFr5sYbQRdfy4' => 
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
        'as' => 'generated::qqNFFr5sYbQRdfy4',
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
    'generated::FeUcR6u3dPz0aPPj' => 
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
        'as' => 'generated::FeUcR6u3dPz0aPPj',
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
    'generated::Ptc9mEb8lmcIbp4m' => 
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
        'as' => 'generated::Ptc9mEb8lmcIbp4m',
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
    'generated::a8Jtd6testzalfwX' => 
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
        'as' => 'generated::a8Jtd6testzalfwX',
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
    'generated::uB6msWhfNda2oaZM' => 
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
        'as' => 'generated::uB6msWhfNda2oaZM',
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
    'generated::EImmIILT7NTQYD4d' => 
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
        'as' => 'generated::EImmIILT7NTQYD4d',
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
    'generated::9txga54wEotyerSe' => 
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
        'as' => 'generated::9txga54wEotyerSe',
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
    'generated::IS0oUwaFkcagjiEa' => 
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
        'as' => 'generated::IS0oUwaFkcagjiEa',
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
    'generated::Cfuvqi6nlhQTHjN9' => 
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
        'as' => 'generated::Cfuvqi6nlhQTHjN9',
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
    'generated::cHugLyxhHHKdJ8ec' => 
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
        'as' => 'generated::cHugLyxhHHKdJ8ec',
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
    'generated::76TpaAI5a86iBQe3' => 
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
        'as' => 'generated::76TpaAI5a86iBQe3',
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
    'generated::S2FAw5D2gy3JpJ6a' => 
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
        'as' => 'generated::S2FAw5D2gy3JpJ6a',
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
    'generated::K1WMLlLFb4e2pWoY' => 
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
        'as' => 'generated::K1WMLlLFb4e2pWoY',
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
    'generated::ET6YKOP8RXKSY5it' => 
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
        'as' => 'generated::ET6YKOP8RXKSY5it',
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
    'generated::SniAJMIwiL6PMe4s' => 
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
        'as' => 'generated::SniAJMIwiL6PMe4s',
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
    'generated::YluIjEQsaGcRNHUA' => 
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
        'as' => 'generated::YluIjEQsaGcRNHUA',
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
    'generated::Kug7QFiUQp9AWVGD' => 
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
        'as' => 'generated::Kug7QFiUQp9AWVGD',
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
    'generated::kgymLUxOY3x03yfE' => 
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
        'as' => 'generated::kgymLUxOY3x03yfE',
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
    'generated::oRBOLPZBZ5ghFpQW' => 
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
        'as' => 'generated::oRBOLPZBZ5ghFpQW',
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
    'generated::WifXfL0st7UEU1AZ' => 
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
        'as' => 'generated::WifXfL0st7UEU1AZ',
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
    'generated::3NzqvDz8BvieSyWt' => 
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
        'as' => 'generated::3NzqvDz8BvieSyWt',
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
    'generated::1XjUXWWMtajQ0De9' => 
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
        'as' => 'generated::1XjUXWWMtajQ0De9',
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
    'generated::vQr90gKa0aDWem9N' => 
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
        'as' => 'generated::vQr90gKa0aDWem9N',
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
    'generated::EaVuSVm5AOqLthVt' => 
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
        'as' => 'generated::EaVuSVm5AOqLthVt',
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
    'generated::UDRu0ZU5UGKvIfbu' => 
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
        'as' => 'generated::UDRu0ZU5UGKvIfbu',
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
    'generated::M246aPGXA9dfLqtr' => 
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
        'as' => 'generated::M246aPGXA9dfLqtr',
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
    'generated::nHiuTJqyoZQrL5GA' => 
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
        'as' => 'generated::nHiuTJqyoZQrL5GA',
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
    'generated::Mb9qV5SmmnHGLghV' => 
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
        'as' => 'generated::Mb9qV5SmmnHGLghV',
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
    'generated::gPE8YuCn6ej8RFHy' => 
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
        'as' => 'generated::gPE8YuCn6ej8RFHy',
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
    'generated::KMxgClwsF0Qc5Nw5' => 
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
        'as' => 'generated::KMxgClwsF0Qc5Nw5',
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
    'generated::203QdDuXU71GxYDf' => 
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
        'as' => 'generated::203QdDuXU71GxYDf',
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
    'generated::CLQrm6o8kNxYSkeb' => 
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
        'as' => 'generated::CLQrm6o8kNxYSkeb',
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
    'generated::FsLEvhwfCd1nmMQv' => 
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
        'as' => 'generated::FsLEvhwfCd1nmMQv',
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
    'generated::CMs9AARsRVOCYSc9' => 
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
        'as' => 'generated::CMs9AARsRVOCYSc9',
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
    'generated::XwrDiJ8r5eHYOW8k' => 
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
        'as' => 'generated::XwrDiJ8r5eHYOW8k',
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
    'generated::TedKBRm5EphcC4FJ' => 
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
        'as' => 'generated::TedKBRm5EphcC4FJ',
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
    'generated::38dEgfDCzafw05bT' => 
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
        'as' => 'generated::38dEgfDCzafw05bT',
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
    'generated::8JcnJVBEhYUHYXkg' => 
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
        'as' => 'generated::8JcnJVBEhYUHYXkg',
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
    'generated::Hmguj6VZlthQjtvC' => 
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
        'as' => 'generated::Hmguj6VZlthQjtvC',
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
    'generated::RcNXqjISgD8RZiiN' => 
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
        'as' => 'generated::RcNXqjISgD8RZiiN',
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
    'generated::teKeJZuAGpSDl0EI' => 
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
        'as' => 'generated::teKeJZuAGpSDl0EI',
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
    'generated::2BO3eQuF66l2iMHB' => 
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
        'as' => 'generated::2BO3eQuF66l2iMHB',
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
    'generated::yYdKCFnMes90ggco' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:829:"function () {
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

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'C:\\\\lumko\\\\teachmeapp-custom\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"000000000000092a0000000000000000";}}',
        'as' => 'generated::yYdKCFnMes90ggco',
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
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:25:"fn () => \\inertia(\'Home\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000007580000000000000000";}}',
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
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:31:"fn () => \\inertia(\'HowItWorks\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000075a0000000000000000";}}',
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
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:28:"fn () => \\inertia(\'Pricing\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000075c0000000000000000";}}',
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
    'generated::UE54Js6v7N5ntavJ' => 
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
        'as' => 'generated::UE54Js6v7N5ntavJ',
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
    'storage.local' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:46:"C:\\lumko\\teachmeapp-custom\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000008000000000000000000";}}',
        'as' => 'storage.local',
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
    'storage.local.upload' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:46:"C:\\lumko\\teachmeapp-custom\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:325:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ReceiveFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000008020000000000000000";}}',
        'as' => 'storage.local.upload',
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
