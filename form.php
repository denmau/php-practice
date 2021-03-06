<?php
$username = '';
$password = '';
$gender = '';
$fav_color = '';
$languages = array();
$comments = '';
$tc = '';

if (isset($_POST['submit'])) {
    $ok = true;

    // Store Form Data into corresponding variables
    if (!isset($_POST['username']) || $_POST['username'] === '') {
        $ok = false;
    } else {
        $username = $_POST['username'];
    }
    if (!isset($_POST['password']) || $_POST['password'] === '') {
        $ok = false;
    } else {
        $password = $_POST['password'];
    }
    if (!isset($_POST['gender']) || $_POST['gender'] === '') {
        $ok = false;
    } else {
        $gender = $_POST['gender'];
    }
    if (!isset($_POST['fav_color']) || $_POST['fav_color'] === '') {
        $ok = false;
    } else {
        $fav_color = $_POST['fav_color'];
    }
    if (!isset($_POST['languages']) || count($_POST['languages']) === 0 || !is_array($_POST['languages'])) {
        $ok = false;
    } else {
        $languages = $_POST['languages'];
    }
    if (!isset($_POST['comments'])) {
        $ok = false;
    } else {
        $comments = $_POST['comments'];
    }
    if (!isset($_POST['tc'])) {
        $ok = false;
    } else {
        $tc = $_POST['tc'];
    }

// Display From Data
    if ($ok) {
        printf('Hey there, here is what we got from you: <br/>
    Username : %s <br/>
    Password: %s <br/>
    Gender: %s <br/>
    Favourite Color: %s <br/>
    Languages: %s <br/>
    Comments: %s <br/>
    Terms &amp; Conditions: %s <br/>',
            htmlspecialchars($username, ENT_QUOTES),
            htmlspecialchars($password, ENT_QUOTES),
            htmlspecialchars($gender, ENT_QUOTES),
            htmlspecialchars($fav_color, ENT_QUOTES),
            htmlspecialchars(implode(' ', $languages), ENT_QUOTES),
            htmlspecialchars($comments, ENT_QUOTES),
            htmlspecialchars($tc, ENT_QUOTES)
        );

        echo "<br />";
        echo "Saving this data into php database ...";

// Connect to Database
// using experimental username (super insecure)
        $db = new mysqli(
            'localhost',
            'root',
            '',
            'php'
        );

        $sql = sprintf("INSERT INTO users (name, gender, color) VALUES (%s, %s ,%s)",
            // escaping user input
            $db->real_escape_string($username),
//        $username,
            $db->real_escape_string($gender),
//        $gender,
            $db->real_escape_string($fav_color)
//        $fav_color
        );
// send query to database
        $db->query($sql);
        echo "<p>User Added.</p>";
// close Database
        $db->close();
    }
}
?>

<h2>Registration Form</h2>
<br/>

<form
        action=""
        method="post"
>

    <label for="username">Username</label>
    <input type="text" name="username" value="<?php
    echo htmlspecialchars($username, ENT_QUOTES);
    ?>">
    <br/>

    <label for="password">Password</label>
    <input type="password" name="password">
    <br/>

    <label for="gender">Gender</label>
    <input type="radio" name="gender" value="m"<?php
    if ($gender === 'm') {
        echo ' checked';
    }
    ?>>Male
    <input type="radio" name="gender" value="f"<?php
    if ($gender === 'f') {
        echo ' checked';
    }
    ?>>Female
    <input type="radio" name="gender" value="o"<?php
    if ($gender === 'o') {
        echo ' checked';
    }
    ?>>Other
    <br/>

    <label for="fav_color">Favourite Color</label>
    <select name="fav_color">
        <option value="">Select one ...</option>
        <option value="#f00"<?php
        if ($fav_color === '#f00') {
            echo ' selected';
        }
        ?>>Red
        </option>
        <option value="#0f0"<?php
        if ($fav_color === '#0f0') {
            echo ' selected';
        }
        ?>>Green
        </option>
        <option value="#00f"<?php
        if ($fav_color === '#00f') {
            echo ' selected';
        }
        ?>>Blue
        </option>
    </select>
    <br/>

    <label for="languages[]">Language(s) Spoken</label>
    <select name="languages[]" multiple size="3">
        <option value="en"<?php
        if (in_array('en', $languages)) {
            echo ' selected';
        }
        ?>>English
        </option>
        <option value="fr"<?php
        if (in_array('fr', $languages)) {
            echo ' selected';
        }
        ?>>French
        </option>
        <option value="it"<?php
        if (in_array('it', $languages)) {
            echo ' selected';
        }
        ?>>Italian
        </option>
    </select>
    <br/>

    <label for="lang_select">Check Language</label>
    <input type="checkbox" name="lang_select" value="en">English
    <input type="checkbox" name="lang_select" value="fr">French
    <input type="checkbox" name="lang_select" value="it">Italian
    <br/>

    <label for="comments">Comments</label>
    <textarea name="comments">
        <?php
        echo htmlspecialchars($comments, ENT_QUOTES);
        ?>
    </textarea>
    <br/>

    <input type="checkbox" name="tc" value="ok"<?php
    if ($tc === 'ok') {
        echo ' checked';
    }
    ?>>
    I accept the terms &amp; Conditions
    <br/>

    <input type="submit" name="submit" value="Register">

</form>