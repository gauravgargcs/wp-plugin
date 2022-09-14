<?php
require_once(COS_PATH.'vendor/stripe-php-master/init.php');

class cos_StripePayment
{

    private $apiKey;

    private $stripeService;

    public function __construct()
    {
		$cos_options = get_option( 'cos_setting_options' );
        $this->apiKey = $cos_options['stripe']['secret_key']??'';
		// This is a sample test API key.
		\Stripe\Stripe::setApiKey($this->apiKey);
    }
	
	public function charge(){
		$cos_options = get_option( 'cos_setting_options' );
		
		$customer__ = $this->cos_create_customer();
		
		$token = $_POST['stripeToken'];
		
		$real_amount = round($_POST['amount'], 2) * 100;
		
		if($customer__['status'] != 'error'){
			$customer_id = $customer__->id;
		}
		else{
			$customer_id = '';
			return $customer__;
		}
		
		try {
			$charge = \Stripe\Charge::create([
			  'amount' => $real_amount,
			  'currency' => $cos_options['stripe']['currency']??'eur',
			  'description' => 'Booking',
			  'source' => $token,
			  'customer' => $customer_id
			]);
		}
		catch (\Stripe\Exception\CardException $e) {
            $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
        }
		catch (\Stripe\Exception\RateLimitException $e) {
		  $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\InvalidRequestException $e) {
		  $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\AuthenticationException $e) {
		  $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\ApiConnectionException $e) {
		  $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\ApiErrorException $e) {
		  $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (Exception $e) {
		  $charge = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		}
		
		return $charge;
	}
	
	public function cos_paymentIntant(){
		$cos_options = get_option( 'cos_setting_options' );
		$real_amount = round($_POST['amount'], 2) * 100;
		
		try {
			$intent_ = \Stripe\PaymentIntent::create([
			  'amount' => $real_amount,
			  'currency' => $cos_options['stripe']['currency']??'eur',
			  'payment_method_types' => ['card'],
			]);
		}
		catch (\Stripe\Exception\CardException $e) {
            $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
        }
		catch (\Stripe\Exception\RateLimitException $e) {
		  $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\InvalidRequestException $e) {
		  $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\AuthenticationException $e) {
		  $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\ApiConnectionException $e) {
		  $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\ApiErrorException $e) {
		  $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (Exception $e) {
		  $intent_ = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		}
		
		return $intent_;
	}
	
	public function cos_create_customer(){
		try {
			$customer = \Stripe\Customer::create([
			  'email' => $_POST['user_email']??'',
			  'name' => $_POST['full_name']??''
			]);
		}
		catch (\Stripe\Exception\CardException $e) {
            $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
        }
		catch (\Stripe\Exception\RateLimitException $e) {
		  $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\InvalidRequestException $e) {
		  $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\AuthenticationException $e) {
		  $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\ApiConnectionException $e) {
		  $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (\Stripe\Exception\ApiErrorException $e) {
		  $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		} catch (Exception $e) {
		  $customer = array(
                "status" => "error",
                "response" => $e->getError()->message
            );
		}
		
		return $customer;
	}
	
	public function cos_stripe_ajax(){
		//$charge__ = $this->charge();
		$charge__ = $this->cos_paymentIntant();
		wp_send_json($charge__); die;
	}
	
	/*public function create_old(){
		header('Content-Type: application/json');

		try {
			// retrieve JSON from POST body
			$jsonStr = file_get_contents('php://input');
			$jsonObj = json_decode($jsonStr);

			// Create a PaymentIntent with amount and currency
			$paymentIntent = \Stripe\PaymentIntent::create([
				'amount' => calculateOrderAmount($jsonObj->items),
				'currency' => 'inr',
				'automatic_payment_methods' => [
					'enabled' => true,
				],
			]);

			$output = [
				'clientSecret' => $paymentIntent->client_secret,
			];

			echo json_encode($output); die;
		} catch (Error $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]); die;
		}
	}
	
	public function cos_stripe_ajax(){
		$this->create();
	}
	
	public function calculateOrderAmount(array $items): int {
		// Replace this constant with a calculation of the order's amount
		// Calculate the order total on the server to prevent
		// people from directly manipulating the amount on the client
		return 1400;
	}*/
}