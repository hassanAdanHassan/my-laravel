# Implementation Plan: Delivery Process

## Overview

Implement outbound delivery management for the Laravel inventory system. Tasks follow the MVC pattern: migrations → models → form requests → controller → routes → views, with property-based tests using Pest PHP woven in alongside each component.

## Tasks

- [x] 1. Create database migrations
  - [x] 1.1 Create `deliveries` table migration
    - Generate migration file for `deliveries` table with columns: `id`, `customer_id`, `creater_id`, `destination`, `status` (enum: pending/in_transit/delivered/cancelled, default: pending), `in_transit_at`, `delivered_at`, `cancelled_at` (nullable timestamps), and standard `timestamps`
    - Add foreign keys: `customer_id → customers.id`, `creater_id → users.id`
    - _Requirements: 1.1, 7.4_

  - [x] 1.2 Create `delivery_items` table migration
    - Generate migration file for `delivery_items` table with columns: `id`, `delivery_id`, `product_id`, `quantity` (unsignedInteger), `unit_price` (decimal 10,2), and standard `timestamps`
    - Add foreign keys: `delivery_id → deliveries.id` (cascade delete), `product_id → products.id`
    - _Requirements: 2.1, 2.4_

- [x] 2. Implement Eloquent models
  - [x] 2.1 Create `Delivery` model (`app/Models/Delivery.php`)
    - Define `$fillable`: `customer_id`, `creater_id`, `destination`, `status`, `in_transit_at`, `delivered_at`, `cancelled_at`
    - Define `$casts` for the three timestamp fields
    - Add relationships: `customer()` (belongsTo Customer), `creator()` (belongsTo User via `creater_id`), `items()` (hasMany DeliveryItem)
    - Add helpers: `isEditable()` returns true when status is `pending`; `isFinal()` returns true when status is `delivered` or `cancelled`
    - _Requirements: 1.1, 3.1, 6.1_

  - [x] 2.2 Create `DeliveryItem` model (`app/Models/DeliveryItem.php`)
    - Define `$fillable`: `delivery_id`, `product_id`, `quantity`, `unit_price`
    - Add relationships: `product()` (belongsTo products model via `product_id`), `delivery()` (belongsTo Delivery)
    - _Requirements: 2.1, 2.4_

  - [ ]* 2.3 Write property test for unit price snapshot (Property 9)
    - **Property 9: Unit price snapshot**
    - For 100 deliveries, assert `unit_price` on each DeliveryItem equals `products.price` at creation time, regardless of subsequent price changes
    - Tag: `// Feature: delivery-process, Property 9: unit_price snapshot`
    - **Validates: Requirements 2.4**

- [x] 3. Create Form Request classes
  - [x] 3.1 Create `StoreDeliveryRequest` (`app/Http/Requests/StoreDeliveryRequest.php`)
    - Rules: `customer_id` required|exists:customers,id; `destination` required|string|max:255; `items` required|array|min:1; `items.*.product_id` required|exists:products,id; `items.*.quantity` required|integer|min:1
    - Add a custom `withValidator` or `after` hook that checks each item's quantity against `products.amount` and fails with a descriptive message if stock is insufficient
    - _Requirements: 1.2, 1.3, 2.1, 2.2_

  - [x] 3.2 Create `UpdateDeliveryRequest` (`app/Http/Requests/UpdateDeliveryRequest.php`)
    - Same rules as `StoreDeliveryRequest`
    - _Requirements: 6.1, 6.2_

  - [ ]* 3.3 Write property test for quantity-exceeds-stock rejection (Property 3)
    - **Property 3: Quantity exceeding stock is rejected**
    - For 100 items where quantity > product.amount, assert the POST /delivery/store request returns a validation error and no Delivery record is created
    - Tag: `// Feature: delivery-process, Property 3: quantity exceeding stock is rejected`
    - **Validates: Requirements 2.2, 4.2**

  - [ ]* 3.4 Write property test for delivery requires at least one item (Property 2)
    - **Property 2: Delivery requires at least one item**
    - For 100 requests with an empty items array, assert the request is rejected and no Delivery record is persisted
    - Tag: `// Feature: delivery-process, Property 2: delivery requires at least one item`
    - **Validates: Requirements 1.2, 2.1**

- [x] 4. Implement `DeliveryController` — create and store
  - [x] 4.1 Scaffold `DeliveryController` (`app/Http/Controllers/DeliveryController.php`)
    - Create the controller class with all eight method stubs: `index`, `create`, `store`, `show`, `edit`, `update`, `updateStatus`, `destroy`
    - _Requirements: 1.1_

  - [x] 4.2 Implement `create()` and `store()` methods
    - `create()`: load all customers and products, return `delivery.create` view
    - `store(StoreDeliveryRequest $request)`: create Delivery with `status = pending` and `creater_id = auth()->id()`; loop over `items` array to create DeliveryItems with `unit_price` snapshotted from `products.price`; redirect to index with success message
    - _Requirements: 1.1, 1.4, 2.3, 2.4, 7.4_

  - [ ]* 4.3 Write property test for new delivery starts as pending (Property 1)
    - **Property 1: New delivery starts as pending**
    - For 100 random valid payloads, assert the created Delivery record has status `pending`
    - Tag: `// Feature: delivery-process, Property 1: new delivery always starts as pending`
    - **Validates: Requirements 1.1**

- [x] 5. Implement `DeliveryController` — index and show
  - [x] 5.1 Implement `index()` method
    - Return DataTables JSON (with eager-loaded customer and creator) when the request is AJAX; otherwise return `delivery.index` view
    - Support filtering by `status` query parameter
    - _Requirements: 5.1, 5.2, 5.4_

  - [x] 5.2 Implement `show()` method
    - Load Delivery with eager-loaded `items.product`, `customer`, and `creator`; return `delivery.show` view
    - _Requirements: 5.3_

- [x] 6. Implement `DeliveryController` — edit, update, and destroy
  - [x] 6.1 Implement `edit()` and `update()` methods
    - `edit(string $id)`: abort 403 if delivery is not `pending`; load customers and products; return `delivery.edit` view
    - `update(UpdateDeliveryRequest $request, string $id)`: abort 403 if not `pending`; sync delivery fields and replace DeliveryItems (delete old, insert new with fresh `unit_price` snapshot); redirect to show with success
    - _Requirements: 6.1, 6.2, 6.3_

  - [x] 6.2 Implement `destroy()` method
    - Abort 403 if delivery is already `delivered` or `cancelled`; set status to `cancelled` and set `cancelled_at = now()`; redirect to index with success
    - _Requirements: 3.5, 6.4_

  - [ ]* 6.3 Write property test for only pending deliveries are editable (Property 7)
    - **Property 7: Only pending deliveries are editable**
    - For 100 edit attempts on deliveries with status `in_transit`, `delivered`, or `cancelled`, assert the response is 403 and the delivery record is unchanged
    - Tag: `// Feature: delivery-process, Property 7: only pending deliveries are editable`
    - **Validates: Requirements 6.2**

  - [ ]* 6.4 Write property test for cancellation does not affect stock (Property 8)
    - **Property 8: Cancellation does not affect stock**
    - For 100 cancellations from `pending` or `in_transit` status, assert no product's `amount` is modified
    - Tag: `// Feature: delivery-process, Property 8: cancellation does not affect stock`
    - **Validates: Requirements 3.5, 6.4**

- [ ] 7. Implement `updateStatus` and stock deduction
  - [ ] 7.1 Implement `updateStatus()` method
    - Reject update if delivery `isFinal()`; redirect back with error
    - When transitioning to `in_transit`: set `in_transit_at = now()`
    - When transitioning to `delivered`: run `DB::transaction` — for each item, lock product row, check `amount >= quantity` (throw exception if not), then `decrement('amount', $item->quantity)`; set `delivered_at = now()`
    - When transitioning to `cancelled`: set `cancelled_at = now()` (no stock change)
    - _Requirements: 3.2, 3.3, 3.4, 3.5, 4.1, 4.2, 4.3_

  - [ ]* 7.2 Write property test for stock deduction round trip (Property 4)
    - **Property 4: Stock deduction round trip**
    - For 100 deliveries marked as `delivered`, assert each product's `amount` after equals `amount` before minus the item quantity
    - Tag: `// Feature: delivery-process, Property 4: stock deduction round trip`
    - **Validates: Requirements 4.1**

  - [ ]* 7.3 Write property test for transactional stock deduction (Property 5)
    - **Property 5: Transactional stock deduction**
    - For 100 deliveries where at least one item would reduce stock below zero, assert no product's `amount` is modified (full rollback)
    - Tag: `// Feature: delivery-process, Property 5: transactional stock deduction`
    - **Validates: Requirements 4.2, 4.3**

  - [ ]* 7.4 Write property test for final status is immutable (Property 6)
    - **Property 6: Final status is immutable**
    - For 100 attempts to update a `delivered` or `cancelled` delivery, assert the status and all fields remain unchanged
    - Tag: `// Feature: delivery-process, Property 6: final status is immutable`
    - **Validates: Requirements 3.4**

- [ ] 8. Register routes
  - [ ] 8.1 Add delivery routes to `routes/web.php`
    - Wrap all eight routes in `middleware(["auth", "admin"])->prefix("delivery")->name("delivery.")` group
    - Register: GET index, GET create, POST store, GET {id} (show), GET edit/{id}, POST update/{id}, POST update-status/{id}, POST destroy/{id}
    - _Requirements: 7.1, 7.2, 7.3_

- [ ] 9. Build Blade views
  - [ ] 9.1 Create `resources/views/delivery/index.blade.php`
    - Extend `master`; render AdminLTE card with DataTables table (columns: ID, Customer, Status, Destination, Creator, Created At, Actions)
    - Add status filter dropdown above the table; pass filter value as DataTables query parameter
    - Include action links for show, edit, and cancel (destroy)
    - _Requirements: 5.1, 5.2, 5.4_

  - [ ] 9.2 Create `resources/views/delivery/create.blade.php`
    - Extend `master`; render form POSTing to `delivery.store`
    - Customer select, destination text input, and a dynamic items section (JS add/remove rows) with product select and quantity input per row
    - Display inline validation errors; show unit price alongside each product select (populated via JS on product change)
    - _Requirements: 1.2, 1.3, 2.1, 2.4_

  - [ ] 9.3 Create `resources/views/delivery/edit.blade.php`
    - Extend `master`; same form structure as create, pre-populated with existing delivery data and items
    - POSTs to `delivery.update`; show read-only notice if delivery is not `pending`
    - _Requirements: 6.1, 6.2_

  - [ ] 9.4 Create `resources/views/delivery/show.blade.php`
    - Extend `master`; display full delivery record (customer, destination, status, creator, timestamps)
    - Items table with product name, quantity, and unit price
    - Status update form with allowed next-status options; disable form if delivery `isFinal()`
    - _Requirements: 5.3, 3.1, 3.2, 3.3_

- [ ] 10. Final checkpoint — Ensure all tests pass
  - Run `php artisan migrate:fresh --seed` to verify migrations apply cleanly
  - Run `./vendor/bin/pest --filter delivery` to confirm all feature and property tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for a faster MVP
- Each task references specific requirements for traceability
- Property tests use Pest PHP with a minimum of 100 iterations each and must include the tag comment referencing the property number
- The `creater_id` column name intentionally matches the existing codebase typo
- Stock deduction must always run inside `DB::transaction` with `lockForUpdate()` to prevent race conditions
