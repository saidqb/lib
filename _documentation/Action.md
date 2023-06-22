# Action
location:
filament/support/src/actions/concerns
```
Action::make('custom_action')
->disableForm(bool | Closure $condition = true)
->form(array | Closure $schema)
->mutateFormDataUsing(?Closure $callback)
->resetFormData()
->getFormData()
->mount(array $parameters)
->action(Closure | string | null $action)

// HasLifecycleHooks
->before(Closure $callback)
->after(Closure $callback)
->beforeFormFilled(Closure $callback)
->afterFormFilled(Closure $callback)
->beforeFormValidated(Closure $callback)
->afterFormValidated(Closure $callback)

// CanRequireConfirmation
->requiresConfirmation(bool | Closure $condition = true)

// CanRedirect
->redirect(string | Closure $url)
->failureRedirectUrl(string | Closure | null $url)
->successRedirectUrl(string | Closure | null $url)

// CanOpenModal

->centerModal(bool | Closure | null $condition = true)
->slideOver(bool | Closure $condition = true)
->modalActions(array | Closure | null $actions = null)
->extraModalActions(array | Closure $actions)
->modalSubmitAction(ModalAction | Closure | null $action = null)
->modalCancelAction(ModalAction | Closure | null $action = null)
->modalButton(string | Closure | null $label = null)
->modalContent(View | Htmlable | Closure | null $content = null)
->modalFooter(View | Htmlable | Closure | null $content = null)
->modalHeading(string | Htmlable | Closure | null $heading = null)
->modalSubheading(string | Htmlable | Closure | null $subheading = null)
->modalWidth(string | Closure | null $width = null)
->modalHidden(bool | Closure | null $condition = false)

// HasWizard
->steps(array | Closure $steps)
->startOnStep(int | Closure $startStep)
->skippableSteps(bool | Closure $condition = true)

// CanNotify
->failureNotification(Notification | Closure | null $notification)
->failureNotificationMessage(string | Closure | null $message)
->failureNotificationTitle(string | Closure | null $title)
->successNotification(Notification | Closure | null $notification)
->successNotificationMessage(string | Closure | null $message)
->successNotificationTitle(string | Closure | null $title)
```

## example Action

use App\Tables\Columns\ButtonColumn;

// custom coloumn table action
ButtonColumn::make('advance')
->label('data')
->icon('heroicon-o-collection')
->actionLabel('modal')
->action(
Action::make('modal')
->label('data')
->form([Textarea::make('comment')])
->action(fn (array $data, $record) => ($record))
),

// resource action
->actions([
Tables\Actions\EditAction::make(),

])
->bulkActions([
Tables\Actions\DeleteBulkAction::make(),
])