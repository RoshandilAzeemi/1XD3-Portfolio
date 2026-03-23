<form action="process_vote.php" method="POST">
    <label for="poll_id">Poll ID:</label>
    <input type="number" name="poll_id" required min="1">

    <label for="option">Choose an Option:</label>
    <select name="option" required>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>

    <button type="submit">Cast Vote</button>
</form>