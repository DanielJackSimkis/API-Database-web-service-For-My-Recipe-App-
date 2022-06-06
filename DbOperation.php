<?php
 
	class DbOperation
	{
		//Database connection link
		private $con;
	 
		//Class constructor
		function __construct()
		{
			//Getting the DbConnect.php file
			require_once dirname(__FILE__) . '/DbConnect.php';
	 
			//Creating a DbConnect object to connect to the database
			$db = new DbConnect();
	 
			//Initializing our connection link of this class
			//by calling the method connect of DbConnect class
			$this->con = $db->connect();
		}
	 
	 /*
	 * The create operation
	 * When this method is called a new record is created in the database
	 */
	 function createIngredient($ingredientName, $ingredientType){
		 $stmt = $this->con->prepare("INSERT INTO ingredients_table (ingredientName, ingredientType) VALUES (?,?)");
		 if($stmt !== FALSE)
			$stmt->bind_param("ss", $ingredientName, $ingredientType);
		 
		 if($stmt->execute())
			return true; 
		
		 return false; 
	 }
	 
	 /*
	 * The create operation
	 * When this method is called a new record is created in the database
	 */
	 function createRecipe($recipeTitle, $amountRecipeFeeds, $cookTime, $imageUrl, $difficulty, $recipeDiscription, $author){

		 $stmt = $this->con->prepare("INSERT INTO recipes (recipeTitle, amountRecipeFeeds, cookTime, imageUrl, difficulty, recipeDiscription, author) VALUES (?, ?, ?, ?, ?, ?, ?)");
		 if($stmt !== FALSE)
			$stmt->bind_param("sssssss", $recipeTitle, $amountRecipeFeeds, $cookTime, $imageUrl, $difficulty, $recipeDiscription, $author);
		 
		 if($stmt->execute())
			return true; 
		
		 return false; 
	 }
	 
	 /*
	 * The create operation
	 * When this method is called a new record is created in the database
	 */
	 function createIngredientsUsed($recipeIdFk, $ingredientIdFk){

		 $stmt = $this->con->prepare("INSERT INTO ingredients_used (recipeIdFk, ingredientIdFk) VALUES (?, ?)");
		 if($stmt !== FALSE)
			$stmt->bind_param("ii", $recipeIdFk, $ingredientIdFk);
		 
		 if($stmt->execute())
			return true; 
		
		 return false; 
	 } 
	 
	  /* /*
	 * The create operation
	 * When this method is called a new record is created in the database
	 */
	 function createSavedRecipe($userId, $recipeIdFk){

		 $stmt = $this->con->prepare("INSERT INTO savedRecipes (userId, recipeIdFk) VALUES (?, ?)");
		 if($stmt !== FALSE)
			$stmt->bind_param("si", $userId, $recipeIdFk);
		 
		 if($stmt->execute())
			return true; 
		
		 return false; 
	 }
	 * The create operation
	 * When this method is called a new record is created in the database
	 */
	 
	 function createReview($recipeTitle, $amountRecipeFeeds, $cookTime, $imageUrl, $difficulty, $recipeDiscription, $author){

		 $stmt = $this->con->prepare("INSERT INTO recipes (recipeTitle, amountRecipeFeeds, cookTime, imageUrl, difficulty, recipeDiscription, author) VALUES (?, ?, ?, ?, ?, ?, ?)");
		 if($stmt !== FALSE)
			$stmt->bind_param("sssssss", $recipeTitle, $amountRecipeFeeds, $cookTime, $imageUrl, $difficulty, $recipeDiscription, $author);
		 
		 if($stmt->execute())
			return true; 
		
		 return false; 
	 }
	 
	 /*
	 * The create operation
	 * When this method is called a new record is created in the database
	 */
	 function createUser($title, $firstName, $lastName, $username, $password){

		 $stmt = $this->con->prepare("INSERT INTO users (title, firstName, lastName, username, password) VALUES (?, ?, ?, ?, ?)");
		 if($stmt !== FALSE)
			$stmt->bind_param("sssss", $title, $firstName, $lastName, $username, $password);
		 
		 if($stmt->execute())
			return true; 
		
		 return false; 
	 }

	 
	 /*
	 * The read operation
	 * When this method is called it is returning all the existing record of the database
	 */
	 function getIngredients($ingredientType){
		 $stmt = $this->con->prepare("SELECT ingredientId, ingredientName, ingredientType FROM ingredients_table WHERE ingredientType = ?");
		 $stmt->bind_param("s", $ingredientType);
		 $stmt->execute();
		 $stmt->bind_result($ingredientId, $ingredientName, $ingredientType);
		 $ingredients = array(); 
		 
		 while($stmt->fetch()){
			 $ingredient = array();
			 $ingredient['ingredientId'] = $ingredientId; 
			 $ingredient['ingredientName'] = $ingredientName; 
			 $ingredient['ingredientType'] = $ingredientType; 

		 
			array_push($ingredients, $ingredient); 
		 }
		 
		return $ingredients; 
	 }

	/*
	 * The read operation
	 * When this method is called it is returning all the existing record of the database
	 */
	 function getRecipeByIngredients($includedIngredients){
		 
		 $stmt = $this->con->prepare("SELECT recipeTitle, amountRecipeFeeds, cookTime, imageUrl, difficulty, recipeDiscription, author, ingredientId, 
												ingredientName, ingredientType FROM ingredients_table i 
												JOIN ingredients_used iu ON (i.ingredientId = iu.ingredientIdFk)
												JOIN recipes r ON (iu.recipeIdFk = r.recipeId)
												WHERE i.ingredientName IN ?");
		 $stmt->bind_param("a", $includedIngredients);
		 $stmt->execute();
		 $stmt->bind_result($recipeId, $recipeTitle, $amountRecipeFeeds, $cookTime, 
							$imageUrl, $difficulty, $recipeDiscription, $author,
							$ingredientId, $ingredientName, $ingredientType);
		 
		 $results = array(); 
		 
		 while($stmt->fetch()){
			$result = array();
			$result['recipeId'] = $recipeId; 
			$result['recipeTitle'] = $recipeTitle; 
			$result['amountRecipeFeeds'] = $amountRecipeFeeds; 
			$result['cookTime'] = $cookTime; 
			$result['imageUrl'] = $imageUrl; 
			$result['difficulty'] = $difficulty; 
			$result['recipeDiscription'] = $recipeDiscription; 
			$result['author'] = $author;
			$result['ingredientId'] = $ingredientId; 
			$result['ingredientName'] = $ingredientName; 
			$result['ingredientType'] = $ingredientType; 

			array_push($results, $result); 
		 }
		 
		return $results; 
	 }
	 
	 /*
	 * The read operation
	 * When this method is called it is returning all the existing record of the database
	 */
	 function getRecipes($recipeTitle){
		 $stmt = $this->con->prepare("SELECT recipeId, recipeTitle, amountRecipeFeeds, cookTime, imageUrl, difficulty, recipeDiscription, author FROM recipes WHERE recipeTitle = ?");
		 $stmt->bind_param("s", $recipeTitle);
		 $stmt->execute();
		 $stmt->bind_result($recipeId, $recipeTitle, $amountRecipeFeeds, $cookTime, 
							$imageUrl, $difficulty, $recipeDiscription, $author);
		 
		 $recipes = array(); 
		 
		 while($stmt->fetch()){
		 $recipe = array();
		 $recipe['recipeId'] = $recipeId; 
		 $recipe['recipeTitle'] = $recipeTitle; 
		 $recipe['amountRecipeFeeds'] = $amountRecipeFeeds; 
		 $recipe['cookTime'] = $cookTime; 
		 $recipe['imageUrl'] = $imageUrl; 
		 $recipe['difficulty'] = $difficulty; 
		 $recipe['recipeDiscription'] = $recipeDiscription; 
		 $recipe['author'] = $author;

		 
		 array_push($recipes, $recipe); 
		 }
		 
		 return $recipes; 
	 }
	 
	 /*
	 * The read operation
	 * When this method is called it is returning all the existing record of the database
	 */
	 function getRecipesById($recipeId){
		 $stmt = $this->con->prepare("SELECT recipeId, recipeTitle, amountRecipeFeeds, cookTime, imageUrl, difficulty, recipeDiscription, author FROM recipes WHERE recipeTitle = ?");
		 $stmt->bind_param("s", $recipeId);
		 $stmt->execute();
		 $stmt->bind_result($recipeId, $recipeTitle, $amountRecipeFeeds, $cookTime, 
							$imageUrl, $difficulty, $recipeDiscription, $author);
		 
		 $recipes = array(); 
		 
		 while($stmt->fetch()){
		 $recipe = array();
		 $recipe['recipeId'] = $recipeId; 
		 $recipe['recipeTitle'] = $recipeTitle; 
		 $recipe['amountRecipeFeeds'] = $amountRecipeFeeds; 
		 $recipe['cookTime'] = $cookTime; 
		 $recipe['imageUrl'] = $imageUrl; 
		 $recipe['difficulty'] = $difficulty; 
		 $recipe['recipeDiscription'] = $recipeDiscription; 
		 $recipe['author'] = $author;

		 
		 array_push($recipes, $recipe); 
		 }
		 
		 return $recipes; 
	 }
	 
	 /*
	 * The read operation
	 * When this method is called it is returning all the existing record of the database
	 */
	 function getSavedRecipes($userId){
		 $stmt = $this->con->prepare("SELECT saveRecipeId, userId, recipeIdFk FROM savedRecipes WHERE userId = ?");
		 $stmt->bind_param("s", $userId);
		 $stmt->execute();
		 $stmt->bind_result($saveRecipeId, $userId, $recipeIdFk);
		 
		 $recipes = array(); 
		 
		 while($stmt->fetch()){
		 $recipe = array();
		 $recipe['saveRecipeId'] = $recipeId; 
		 $recipe['userId'] = $recipeTitle; 
		 $recipe['recipeIdFk'] = $amountRecipeFeeds; 
		 
		 array_push($recipes, $recipe); 
		 }
		 
		 return $recipes; 
	 }
}
?>