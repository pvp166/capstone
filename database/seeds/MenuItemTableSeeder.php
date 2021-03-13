<?php

use Illuminate\Database\Seeder;
use App\Models\MenuManage\MenuItem;
class MenuItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seed for the menu item
        MenuItem::truncate();
        $buffaloChicken = MenuItem::create([
            'name'=> 'Buffalo Chicken Pizza',
            'description' => 'This tangy, spicy pie is made for Game Day. Kick off with Buffalo blue cheese sauce, grilled chicken, red onions, fire-roasted red peppers and mozzarella cheese.',
            'item_type_id' => 1
        ]);
        $chipotleChicken = MenuItem::create([
            'name'=> 'Chipotle Chicken Pizza',
            'description' => 'Smoky, zesty and bold - This Southwest-style flavor-bomb is set off with smoky chipotle sauce, then topped with chipotle chicken, zesty red onions, and melty mozzarella. Me gusta?',
            'item_type_id' => 1
        ]);
        $baconDoubleChesseBurger = MenuItem::create([
            'name'=> 'Bacon Double Cheese Burger',
            'description' => 'Cheeseburger. Pizza. Enough Said - Yeah, we did it. Crush two comfort-food classics in one, with ground beef, bacon crumble and four-cheese blend. Try it with Honey Mustard dipping sauce for extra burger bite!',
            'item_type_id' => 1
        ]);
        $superPlant = MenuItem::create([
            'name'=> 'Supper Plant Pizza',
            'description' => 'Topped with homestyle tomato sauce, mozzarella cheese, plant-based pepperoni and plant-based chorizo crumble. Toppings contain gluten.',
            'item_type_id' => 2
        ]);
        $gardenVeggie = MenuItem::create([
            'name'=> 'Garden Veggie',
            'description' => 'Your daily recommended awesome - Eating your veggies never tasted so good. Bite into the market-fresh crunch of green peppers, fresh mushrooms, juicy roma tomatoes, and mozzarella on a whole grain crust.',
            'item_type_id' => 2
        ]);
        $mediterraneanVegeterian = MenuItem::create([
            'name'=> 'Mediterranean Vegeterian',
            'description' => "Topped with kalamata olives, broccoli, sun-dried tomatoes, grilled zucchini, 
            red onions, feta cheese and mozzarella cheese. A healthy alternative.",
            'item_type_id' => 2
        ]);
        $chickenWings = MenuItem::create([
            'name'=> 'Chicken Wings',
            'description' => " Classic or crispy breaded? Mild or Hot? It's a wing-wing situation! (Sorry.)",
            'item_type_id' => 3
            //
        ]);
        $chickenBites = MenuItem::create([
            'name'=> 'Chicken Bites',
            'description' => "Craving chicken? Grab a bite! The perfect morsel of juicy, 
            all-white-meat chicken, served with the sauce of your choice. Comes in order of 10 or 20.",
            'item_type_id' => 3 //
        ]);
        $cauliflowerBites = MenuItem::create([
            'name'=> 'Cauliflower Bites',
            'description' => "Lightly battered and fried cauliflower florets, 
            served with your choice of dip on the side.",
            'item_type_id' => 3 //
        ]);
        $baconCaesarSalad = MenuItem::create([
            'name'=> 'Bacon Caesar Salad',
            'description' => 'Looking to go green for lunch or dinner? 
            Enjoy a fresh Caesar salad ? and make it even better with bacon. 
            Crisp romaine lettuce with real parmesan, crunchy croutons, 
            smoky bacon and your choice of dressing.',
            
            'item_type_id' => 4 //
        ]);
        $crispyChickenCaesar = MenuItem::create([
            'name'=> 'Crispy Chicken Caesar Salad',
            'description' => 'Looking to go green for lunch or dinner? 
            Enjoy a fresh Caesar salad ? and make it even better with chicken. 
            Crisp romaine lettuce, real parmesan, crunchy croutons, and crispy chicken
             with your choice of dressing.',
            'item_type_id' => 4 //
        ]);
        
        $canPop = MenuItem::create([
            'name'=> 'Pop Can',
            'description' => ' Choose from a variety of Coke products. 
            Available in 355 mL cans.',
            'item_type_id' => 5 //
        ]);
        $dippingsauce = MenuItem::create([
            'name'=> 'Dipping Sauce',
            'description' => ' Want to amp up the flavour of your pizza even more? 
            Dip your hot, fresh slice in one of our delicious sauces. We have got so many to choose from, 
            the possibilities are (almost) endless.?',
            'item_type_id' => 6
        ]);
        $regularDough = MenuItem::create([
            'name'=> 'Regualar Dough',
            'description' => 'Regular Dough, Mozzarella Cheese, Home Style Italian Tomato Sauce',
            'item_type_id' => 7
        ]);
        $regularThinCrust = MenuItem::create([
            'name'=> 'Regualar Thin Crust',
            'description' => 'Regular Thin Crust, Mozzarella Cheese, Home Style Italian Tomato Sauce',
            'item_type_id' => 7
        ]);
        $regularThickCrust = MenuItem::create([
            'name'=> 'Regualar Thick Crust',
            'description' => 'Regular Thick Crust, Mozzarella Cheese, Home Style Italian Tomato Sauce',
            'item_type_id' => 7
        ]);
        MenuItem::create([
            'name'=> 'Broccolli',
            'description' => '',
            'item_type_id' => 8
        ]);
        MenuItem::create([
            'name'=> 'Hot Banana Peppers',
            'description' => '',
            'item_type_id' => 8
        ]);
        MenuItem::create([
            'name'=> 'Bacon Crumble',
            'description' => '',
            'item_type_id' => 8
        ]);
        MenuItem::create([
            'name'=> 'Bacon Strips',
            'description' => '',
            'item_type_id' => 8
        ]);
        MenuItem::create([
            'name'=> 'Pepperoni',
            'description' => '',
            'item_type_id' => 8
        ]);
        
    }
}
