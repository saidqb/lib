# Page

location:
filament/src/Pages/Page

```
public static function registerNavigationItems(): void {}
public static function getNavigationItems(): array {}
public static function getRouteName(): string {}
public static function getMiddlewares(): string | array {}
public static function getUrl(array $parameters = [], bool $isAbsolute = true): string {}
public function render(): View {}
protected function getBreadcrumbs(): array {}
protected static function getNavigationGroup(): ?string {}
protected static function getNavigationIcon(): string {}
protected static function getActiveNavigationIcon(): string {}
protected static function getNavigationLabel(): string {}
protected static function getNavigationBadge(): ?string {}
protected static function getNavigationBadgeColor(): ?string {}
protected static function getNavigationSort(): ?int {}
protected static function getNavigationUrl(): string {}
protected function getActions(): array {}
protected function getFooter(): ?View {}
protected function getHeader(): ?View {}
protected function getHeaderWidgets(): array {}
protected function getHeaderWidgetsColumns(): int | string | array {}
protected function getFooterWidgets(): array {}
protected function getVisibleFooterWidgets(): array {}
protected function getHeading(): string | Htmlable {}
protected function getSubheading(): string | Htmlable | null {}
protected function getTitle(): string | Htmlable {}
protected function getMaxContentWidth(): ?string {}
protected function getLayoutData(): array {}
protected function getViewData(): array {}
protected static function shouldRegisterNavigation(): bool {}
```

## Page Table Form
Enable table and form pada custom page
```
class PageClass extends Page implements Filament\Forms\Contracts\HasForms, Filament\Tables\Contracts\HasTable
```