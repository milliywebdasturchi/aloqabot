<?php
include (__DIR__ . '/Telegram.php');
$telegram = new Telegram('2081308974:AAE_Af7xL-hQZN2tIf9RHNvJY7FMDgBg3sQ');

$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$firstname = $telegram->FirstName();
$lastname = $telegram->LastName();
$fullname = $firstname . ' ' . $lastname;
$userID = $telegram->UserID();
$userName = $telegram->Username();

$connect = new mysqli('localhost','milli483_aloqabot_user','%4SD]Q^kDg{V','milli483_aloqabot');

$main_keyboard = array( 		
    array(
        $telegram->buildKeyboardButton("🤖 Bot haqida"), 
        $telegram->buildKeyboardButton("📬 Savol yuborish")
    ),
    array(
        $telegram->buildKeyboardButton("📂 Ma'lumotlarim")
    )
);

$main_KB = $telegram->buildKeyBoard($main_keyboard, $onetime=false, $resize=true);

$exit_button = array( 
    array(
        $telegram->buildKeyboardButton("Bekor qilish")
    )
);

$exit_KB = $telegram->buildKeyBoard($exit_button, $onetime=false, $resize=true);

if($text == '/start') {
    $query = $connect->query("SELECT * FROM `bot_users` WHERE  `user_id` = '$userID'");
    if($query->num_rows == 0){
        $connect->query("INSERT INTO bot_users (`user_id`, `username`, `firstname`, `lastname`) VALUES ('$userID','$userName','$firstname','$lastname')");
    }
    $content = array(        
        'chat_id' => $chat_id, 		
        'reply_markup' => $main_KB,        
        'text' => 'Assalomu alaykum, <b>' . $fullname . '</b> mening aloqa botimga xush kelibsiz',
        'parse_mode' => 'html'
    );    
    $telegram->sendMessage($content);
}

if($text == '🤖 Bot haqida') {
    $content = array(        
        'chat_id' => $chat_id,         
        'text' => "Ushbu bot men bilan aloqa qilish uchun maxsus yaratildi. <a href='https://github.com/Eleirbag89/TelegramBotPHP'>Batafsil</a>",
        'parse_mode' => 'html'
    );    
    $telegram->sendMessage($content);
}

if($text == '📬 Savol yuborish') {
    $content = array(        
        'chat_id' => $chat_id,
        'reply_markup' => $exit_KB, 
        'text' => "Savol va takliflaringizni shu yerga yuboring.",
    );    
    $telegram->sendMessage($content);
}

if($text == 'Bekor qilish') {
    $content = array(        
        'chat_id' => $chat_id,
        'reply_markup' => $main_KB, 
        'text' => "Kerakli bo'limni tanlang.",
    );    
    $telegram->sendMessage($content);
}