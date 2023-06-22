# Resource

location:
filament/src/Resources/Resource
```
form(Form $form): Form{}
registerNavigationItems(): void{}
getNavigationItems(): array{}
table(Table $table): Table{}
can(string $action, ?Model $record = null): bool{}
authorizeWithGate(bool $condition = true): void{}
ignorePolicies(bool $condition = true): void{}
getBreadcrumb(): string{}
getEloquentQuery(): Builder{}
getGlobalSearchResultActions(Model $record): array{}
getGlobalSearchResultDetails(Model $record): array{}
getGlobalSearchResultTitle(Model $record): string{}
getGlobalSearchResults(string $searchQuery): Collection{}
getLabel(): ?string{}
getModelLabel(): string{}
getModel(): string{}
getPages(): array{}
getPluralLabel(): ?string{}
getRelations(): array{}
getWidgets(): array{}
getRouteBaseName(): string{}
getRoutes(): Closure{}
getMiddlewares(): string | array{}
getSlug(): string{}
getUrl($name = 'index', $params = [], $isAbsolute = true): string{}
getNavigationGroup(): ?string{}
getNavigationIcon(): string{}
shouldRegisterNavigation(): bool{}

```


# Resource Table
location:
filament/src/Resources/Table

public static function table(Table $table): Table {}
```
$table->actions(array | ActionGroup $actions, ?string $position = null)
$table->actionsPosition(?string $position = null)
$table->bulkActions(array $actions)
$table->columns(array $columns)
$table->contentGrid(?array $grid)
$table->defaultSort(string $column, string $direction = 'asc')
$table->filters(array $filters, ?string $layout = null)
$table->filtersLayout(?string $filtersLayout)
$table->recordCheckboxPosition(?string $recordCheckboxPosition)
$table->headerActions(array | ActionGroup $actions)
$table->prependActions(array $actions)
$table->prependBulkActions(array $actions)
$table->prependHeaderActions(array $actions)
$table->poll(?string $interval = '10s')
$table->deferLoading(bool $condition = true)
$table->pushActions(array $actions)
$table->pushBulkActions(array $actions)
$table->pushHeaderActions(array $actions)
$table->reorderable(?string $column = 'sort')
```

# Resource Form
location:
filament/src/Resources/Form

public static function form(Form $form): Form{}
```
$form->columns(array | int | string | null $columns): static
$form->disabled(bool $condition = true): static
$form->modifyBaseComponentUsing(?Closure $callback): static
$form->schema(array | Component | Closure $schema): static
$form->wizard(bool $condition = true): static
$form->modifyBaseComponent(Component $component): void
$form->getSchema(): array
```