<?php
// Server-side code (process-contact-form.php)

// Verify reCAPTCHA response
$recaptchaToken = $_POST['g-recaptcha-response'];
$recaptchaSecretKey = '6LcrJygmAAAAABetGE9JpuIlVKmDWAzTwsGhOyzE'; // Replace with your reCAPTCHA secret key

// Send a POST request to the reCAPTCHA API to validate the token
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
$recaptchaData = array(
  'secret' => $recaptchaSecretKey,
  'response' => $recaptchaToken
);

$recaptchaOptions = array(
  'http' => array(
    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
    'method' => 'POST',
    'content' => http_build_query($recaptchaData)
  )
);

$recaptchaContext = stream_context_create($recaptchaOptions);
$recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
$recaptchaResponse = json_decode($recaptchaResult);

// Check the reCAPTCHA response
if ($recaptchaResponse->success && $recaptchaResponse->action == 'contact' && $recaptchaResponse->score >= 0.5) {
  // reCAPTCHA verification successful, process the form submission
  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  
  // Process the form data, e.g., send an email, store in a database, etc.
  
  // Send a success response
  echo "Form submission successful!";
} else {
  // reCAPTCHA verification failed, handle the error
  echo "reCAPTCHA verification failed. Please try again.";
}
?>
