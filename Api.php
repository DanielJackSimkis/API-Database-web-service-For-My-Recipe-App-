<?php 

	//getting the dboperation class
	require_once '../includes/DbOperation.php';

	//function validating all the paramters are available
	//we will pass the required parameters to this function 
	function isTheseParametersAvailable($params){
		//assuming all parameters are available 
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		//if parameters are missing 
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
			//displaying error
			echo json_encode($response);
			
			//stopping further execution
			die();
		}
	}
	
	//an array to display response
	$response = array();
	
	//if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			//the CREATE operation
			//if the api call value is 'createIngredient'
			//we will create a record in the database
			case 'createIngredient':
				//first check the parameters required for this request are available or not 
				isTheseParametersAvailable(array('ingredientName', 'ingredientType'));
				
				//creating a new dboperation object
				$db = new DbOperation();
				
				//creating a new record in the database
				$result = $db->createIngredient(
					$_POST['ingredientName'],
					$_POST['ingredientType']
				);
			
				//if the record is created adding success to response
				if($result){
					//record is created means there is no error
					$response['error'] = false; 

					//in message we have a success message
					$response['message'] = 'Ingredient added successfully';

					//and we are getting all the ingredinets from the database in the response
					$response['ingredinets'] = $db->getIngredients();
				}else{

					//if record is not added that means there is an error 
					$response['error'] = true; 

					//and we have the error message
					$response['message'] = 'Some error occurred please try again';
				}
				
			break; 
			
			case 'createRecipe':
			
			//first check the parameters required for this request are available or not 
				isTheseParametersAvailable(array('recipeTitle', 'amountRecipeFeeds', 'cookTime', 'imageUrl', 'difficulty', 'recipeDescription', 'author'));
				
				//creating a new dboperation object
				$db = new DbOperation();
				
				//creating a new record in the database
				$result = $db->createRecipe(
					$_POST['recipeTitle'],
					$_POST['amountRecipeFeeds'],
					$_POST['cookTime'],
					$_POST['imageUrl'],
					$_POST['difficulty'],
					$_POST['recipeDescription'],
					$_POST['author']
				);
			
				//if the record is created adding success to response
				if($result){
					//record is created means there is no error
					$response['error'] = false; 

					//in message we have a success message
					$response['message'] = 'Recipe added successfully';

					//and we are getting all the ingredinets from the database in the response
					$response['recipes'] = $db->getRecipes();
				}else{

					//if record is not added that means there is an error 
					$response['error'] = true; 

					//and we have the error message
					$response['message'] = 'Some error occurred please try again';
				}
			
			break;
			
			case 'createSavedRecipe':
			
			//first check the parameters required for this request are available or not 
				isTheseParametersAvailable(array('userId', 'recipeIdFk'));
				
				//creating a new dboperation object
				$db = new DbOperation();
				
				//creating a new record in the database
				$result = $db->createSavedRecipe(
					$_POST['uderId'],
					$_POST['recipeIdFk']
				);
			
				//if the record is created adding success to response
				if($result){
					//record is created means there is no error
					$response['error'] = false; 

					//in message we have a success message
					$response['message'] = 'Recipe saved successfully';

					//and we are getting all the ingredinets from the database in the response
					$response['recipes'] = $db->getRecipes();
				}else{

					//if record is not added that means there is an error 
					$response['error'] = true; 

					//and we have the error message
					$response['message'] = 'Some error occurred please try again';
				}
			
			break;

			case 'createIngredientsUsed':
			
			//first check the parameters required for this request are available or not 
				isTheseParametersAvailable(array('recipeIdFk', 'ingredientIdFk'));
				
				//creating a new dboperation object
				$db = new DbOperation();
				
				//creating a new record in the database
				$result = $db->createIngredientsUsed(
					$_POST['recipeIdFk'],
					$_POST['ingredientIdFk']
				);
			
				//if the record is created adding success to response
				if($result){
					//record is created means there is no error
					$response['error'] = false; 

					//in message we have a success message
					$response['message'] = 'Recipe saved successfully';

					//and we are getting all the ingredinets from the database in the response
					$response['recipes'] = $db->getRecipes();
				}else{

					//if record is not added that means there is an error 
					$response['error'] = true; 

					//and we have the error message
					$response['message'] = 'Some error occurred please try again';
				}
			
			break;
			
			case 'createUser':
			
			//first check the parameters required for this request are available or not 
				isTheseParametersAvailable(array('title', 'firstName', 'lastName', 'username', 'password'));
				
				//creating a new dboperation object
				$db = new DbOperation();
				
				//creating a new record in the database
				$result = $db->createUser(
					$_POST['title'],
					$_POST['firstName'],
					$_POST['lastName'],
					$_POST['username'],
					$_POST['password']
				);
			
				//if the record is created adding success to response
				if($result){
					//record is created means there is no error
					$response['error'] = false; 

					//in message we have a success message
					$response['message'] = 'Recipe added successfully';

					//and we are getting all the ingredinets from the database in the response
					$response['users'] = $db->getUsers();
				}else{

					//if record is not added that means there is an error 
					$response['error'] = true; 

					//and we have the error message
					$response['message'] = 'Some error occurred please try again';
				}
			
			break;
			
			//the READ operation
			//if the call is getIngredients
			case 'getIngredients':	
				$db = new DbOperation();
				
				if($db->getIngredients($_GET['ingredientType'])){
					
					$response['error'] = false; 
					$response['message'] = 'Request successfully completed';
					$response['ingredients'] = $db->getIngredients(
						$_POST['ingredientType']
					);
				}
				
			break; 
			
			//the READ operation
			//if the call is getRecipes
			case 'getRecipes':
				$db = new DbOperation();
				
				if($db->getRecipes($_GET['recipeTitle'])){
					
					$response['error'] = false; 
					$response['message'] = 'Request successfully completed';
					$response['ingredients'] = $db->getRecipes(
						$_GET['recipeTitle']
					);
				}
			break; 

			case 'getRecipesByIngredients':
				$db = new DbOperation();
					
				$includedIngredients = "'".implode("','",array($_GET['ingredients']))."'";
				
				echo $includedIngredients;
				
				if($db->getRecipeByIngredients($includedIngredients)){
					
					$response['error'] = false; 
					$response['message'] = 'Request successfully completed';
					$response['ingredients'] = $db->getRecipesByIngredients(
						$includedIngredients
					);
				}
			break;
			
			//the READ operation
			//if the call is getRecipes
			case 'getRecipesById':
				$db = new DbOperation();
				
				if($db->getRecipes($_GET['recipeId'])){
					
					$response['error'] = false; 
					$response['message'] = 'Request successfully completed';
					$response['ingredients'] = $db->getRecipesById(
						$_GET['recipeId']
					);
				}
			break; 
			
			//the READ operation
			//if the call is getRecipes
			case 'getSavRecipes':
				$db = new DbOperation();
				
				if($db->getRecipes($_GET['userId'])){
					
					$response['error'] = false; 
					$response['message'] = 'Request successfully completed';
					$response['ingredients'] = $db->getRecipes(
						$_GET['userId']
					);
				}
			break; 
			
			//the READ operation
			//if the call is getUsers
			case 'getUsers':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Request successfully completed';
				$response['users'] = $db->getUsers();
			break; 
		}
		
	}else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	
	//displaying the response in json structure 
	echo json_encode($response);
	
	
