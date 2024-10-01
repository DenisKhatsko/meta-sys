SELECT id, COUNT(*) as count
FROM some_table_name
GROUP BY id
HAVING count > 1;
