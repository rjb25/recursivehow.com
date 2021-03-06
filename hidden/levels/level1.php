<?php include('session.php'); ?>
<h1>What is recursion?</h1>
<p>Recursion in most cases is when a function sends changed data back to itself.If the data is not changed, the function will likely result in a loop. Recursion saves code space by reusing the same filter on steadily changing data.</p>
<br>
<br>

<h1>What is an example of recursion?</h1>
<p>If you have ever seen factorials, they are generated by decreasing multiplication. That is done with recursion by calling the origional number then subtracting by one. Again, multiplying by that lower number and continuing until you are multiplying by one. At this point you exit the method. Here are example recursive factorial methods from java php and clojure.
<br>
<br>
<h2>Java</h2>
<pre>
<code>
public method calcFactorial(int factorial){
	if(int>1){
		return factorial*(calcFactorial(factorial-1);	
	}else{
		return 1;
	}
}
</code>
</pre>

<h2>Php</h2>
<pre>
<code>
&lt;?php
function factorialCalc($factorial){
        if ($factorial>1) {
                return ($factorial * factorialCalc($factorial-1));
        }else{
                return 1;
        }
}
echo factorialCalc($_POST["newtext"]);
?>
</code>
</pre>

<h2>Clojure</h2>
<pre>
<code>
(defn factorial
  "Function for calculating factorials"
  [number]
  (if (= number 1)
	number
	(* number (factorial (dec number)))))
</code>
</pre>
<br>

<p>All in all, recursion is when a function calls itself. Type yes in the text field and hit submit when you are comfortable with the above concept.</p>
<form action="userhome.php" method="post">
<input type="text" name="answer">
<input type="submit" value="submit answer">
</form>
<br>
<br>
<br>
<?php if ($_POST['answer'] == 'yes'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
