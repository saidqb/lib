DOC
===============

#### Filter Query By Field
Filter Query versi `key = value`

| Key| Name | Result |
| ---- | --- | ---- |
| `eq` | equal | `field = 'value'` |
| `neq` | not equal | `field != 'value'` |
| `lt` | lower than | `field < 'value'` |
| `gt` | greater than | `field > 'value'` |
| `lte` | lower than equal | `field <= 'value'` |
| `gte` | greater than equal | `field >= 'value'` |
| `le` | like end | `field LIKE 'value%'` |
| `ls` | like start | `field LIKE '%value'` |
| `lse` | like start end | `field LIKE '%value%'` |
| `in` | where IN | `field IN (value)` value diberi sparator `,` contoh `1,2,3,4` / `1` |
| `nin` | where NOT IN | `field NOT IN (value)` value diberi sparator `,` contoh `1,2,3,4` / `1` |

### Sort, Dir, Limit, Page
1. Sort => `sort=-user_name` => `SORT user_name DESC`
2. Sort => `sort=user_name` => `SORT user_name ASC`
3. Sort => field sort sesuai dengan result
4. Limit => default 10 
5. Page => default 1
6. search => `search=keyword` 

