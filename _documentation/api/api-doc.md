DOC
===============


#### Filter Query By Array
Filter query versi array

| Type | Field | Comparison | Value |
| ---- | ----- | ---------- | ----- |
| `string` | Field dari result | 1. '=': `field = 'value'`  2. '<': `field LIKE 'value%'` 3. '>': `field LIKE '%value'`  4. '<>': `field LIKE '%value%'`  | value yang akan di search |
| `numeric` | Field dari result | 1. '=': `field = value`  2. '<': `field < value` 3. '>': `field > value` 4. '<=': `field <= value` 5. '>=': `field >= value`  6. '<>': `field <> value`  | integer value. jika bukan integer tidak menghasilkan query |
| `list` | Field dari result | 1. 'yes': `field IN (value)` 2. 'no': `field NOT IN (value)` 3. 'bet': `field BETWEEN 'value[0]' AND 'value[1]'` | value harus ada sparator `::`
| `date` | Field dari result | 1. '=': `field = 'value'`  2. '<': `field < 'value'` 3. '>': `field > 'value'` 4. '<=': `field <= 'value'` 5. '>=': `field >= 'value'`  6. '<>': `field <> 'value'` 7. 'bet': `field BETWEEN 'value[0]' AND 'value[1]'` | format tanggal `YYYY-MM-DD` / `2020-12-31`. format tanggal & waktu `YYYY-MM-DD HH:mm:ss` / `2020-12-31 18:28:10` untuk comparison `bet` harus ada sparator `::`|

Contoh 
```
filter[0][type]:string
filter[0][field]:[user_name]
filter[0][value]:omracun
filter[0][comparison]:<>
filter[1][type]:string
filter[1][field]:[user_id]
filter[1][value]:10
filter[1][comparison]:<=
```
hasil query adalah ``select * from user WHERE 1 AND user_name LIKE '%omracun%' AND user_id <= 10;``

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

Note:
1. untuk format tanggal `YYYY-MM-DD` / `2020-12-31` (field dengan akhiran date)
2. untuk format tanggal & waktu `YYYY-MM-DD HH:mm:ss` / `2020-12-31 20:21:10` (field dengan akhiran datetime)
3. jika tanpa key `field[]=value` / `field=value` akan didefault `field = 'value'`

Contoh
```
user_id[gte]:5
user_id[lte]:20
user_name[lse]:omracun
user_join_datetime:2020-08-09
```
hasil query adalah ``select * from user WHERE 1 AND user_id >= 5 AND user_id <= 20 AND user_name LIKE '%omracun%' AND DATE(user_join_datetime) = '2020-08-09'; ``

### Sort, Dir, Limit, Page
1. Sort => `sort=-user_name` => `SORT user_name DESC`
2. Sort => `sort=user_name` => `SORT user_name ASC`
3. Sort => field sort sesuai dengan result
4. Limit => default 10 
5. Page => default 1


## Respon API
#### HTTP CODE
- 200 ( Untuk semua respon )
- 400 ( Untuk token tidak valid / expired )

yes