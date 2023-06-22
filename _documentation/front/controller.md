### load view
```
$data = [
	'item' = [],
	'items' = [],
]
$this->layout()->view('post',$data);
```
$this->layout() = 'front.default.layout.index'

$this->layout('blank') = 'front.default.layout.blank'

### set notfound

return $this->notFound();

blade view in
front.default.layout.404

