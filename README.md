

ssh -i ec2_upsc_keypair.pem ubuntu@44.204.140.47
cd /var/www/upscwebsiteoneaimfront/backend-oneaim_admin



mysql -h database-1.c6f2i6o0eq8i.us-east-1.rds.amazonaws.com -P 3306 -u admin_oneaim -p 
theoneaim03
SHOW DATABASES;
USE database_oneaim;
SHOW TABLES;



sudo php artisan config:clear
sudo php artisan config:cache
sudo php artisan route:clear
php artisan view:clear
php artisan optimize:clear
sudo systemctl restart nginx

sudo systemctl restart php8.3-fpm




<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://theoneaim.co.in',
        'https://theoneaim.co.in',
        'http://98.81.53.167:3000',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        '*',
    ],

    'exposed_headers' => [
        'Authorization',
        'X-API-KEY',
        'Content-Type',
        'X-Requested-With',
        'Accept',
        'Origin',
    ],

    'max_age' => 0,

    'supports_credentials' => false,

];
ubuntu@ip-10-0-1-86:/var/www/upscwebsiteoneaimfront/backend-oneaim_admin$



<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver'   => 'token',
            'provider' => 'users',
            'hash'     => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],

];


<script>
    Dropzone.options.studyMaterialDropzone = {
    url: '{{ route('admin.courses.storeMedia') }}',
    maxFilesize: 100, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      // multiple files ke liye hidden input array banega
      $('form').append('<input type="hidden" name="study_material[]" value="' + response.name + '">')
    },
 removedfile: function (file) {
  file.previewElement.remove();
  if (file.status !== 'error') {
    // Dropzone se aaye naye file me upload.filename hota hai
    // Purane file me sirf file.file_name hota hai
    var name = file.upload ? file.upload.filename : file.file_name;
    $('form').find('input[name="study_material[]"][value="' + name + '"]').remove();
  }
},

    init: function () {
@if(isset($course) && $course->study_material)
      var files = {!! json_encode($course->study_material) !!};
      for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="study_material[]" value="' + file.file_name + '">')

     
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }
         return _results
     }
}
</script>


