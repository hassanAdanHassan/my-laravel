# Requirements Document

## Introduction

The Delivery Process feature extends the existing inventory/stock management system to handle outbound deliveries of products to customers. It covers the full lifecycle of a delivery: creation, item assignment, status tracking, and stock deduction. The feature integrates with the existing Customer, Product, Location, and User models and follows the established Laravel MVC patterns and AdminLTE UI conventions of the application.

## Glossary

- **Delivery**: A record representing a shipment of one or more products to a customer at a specific destination.
- **Delivery_Item**: A line item within a Delivery, linking a specific Product with a quantity to be delivered.
- **Delivery_Controller**: The Laravel controller responsible for managing Delivery CRUD operations.
- **Delivery_Status**: The current state of a Delivery. Valid values are: `pending`, `in_transit`, `delivered`, `cancelled`.
- **Stock**: The available quantity (`amount`) of a Product in the `products` table.
- **Creator**: The authenticated User who creates or manages a Delivery.
- **System**: The Laravel inventory management web application.

---

## Requirements

### Requirement 1: Create a Delivery

**User Story:** As a warehouse manager, I want to create a new delivery order for a customer, so that I can track outbound shipments of products.

#### Acceptance Criteria

1. WHEN a Creator submits a valid delivery creation form, THE Delivery_Controller SHALL create a new Delivery record with status `pending`, linked to the selected Customer, destination address, and Creator.
2. THE System SHALL require a Customer, a destination address, and at least one Delivery_Item when creating a Delivery.
3. IF the submitted form is missing required fields, THEN THE Delivery_Controller SHALL return validation errors without creating a Delivery record.
4. WHEN a Delivery is created, THE System SHALL display a success notification and redirect the Creator to the Delivery index page.

---

### Requirement 2: Manage Delivery Items

**User Story:** As a warehouse manager, I want to add products and quantities to a delivery, so that I can specify exactly what is being shipped.

#### Acceptance Criteria

1. WHEN a Creator adds a Delivery_Item, THE System SHALL require a valid Product and a quantity greater than zero.
2. IF the requested quantity of a Delivery_Item exceeds the current Stock of the selected Product, THEN THE System SHALL reject the Delivery_Item and return a descriptive error message indicating insufficient stock.
3. THE System SHALL allow multiple Delivery_Items with distinct Products to be included in a single Delivery.
4. WHEN a Delivery_Item is added, THE System SHALL display the unit price from the Product record alongside the quantity.

---

### Requirement 3: Track Delivery Status

**User Story:** As a warehouse manager, I want to update the status of a delivery, so that I can track its progress from creation to completion.

#### Acceptance Criteria

1. THE System SHALL support the following Delivery_Status values: `pending`, `in_transit`, `delivered`, `cancelled`.
2. WHEN a Creator updates a Delivery status to `in_transit`, THE Delivery_Controller SHALL update the Delivery_Status and record the transition timestamp.
3. WHEN a Creator updates a Delivery status to `delivered`, THE Delivery_Controller SHALL update the Delivery_Status, record the delivery timestamp, and deduct each Delivery_Item quantity from the corresponding Product Stock.
4. IF a Creator attempts to update the status of a `delivered` or `cancelled` Delivery, THEN THE Delivery_Controller SHALL reject the update and return an error message stating the Delivery cannot be modified.
5. WHEN a Creator cancels a Delivery with status `pending` or `in_transit`, THE Delivery_Controller SHALL set the Delivery_Status to `cancelled` without modifying Product Stock.

---

### Requirement 4: Deduct Stock on Delivery Completion

**User Story:** As a warehouse manager, I want stock levels to be automatically reduced when a delivery is marked as delivered, so that inventory counts remain accurate.

#### Acceptance Criteria

1. WHEN a Delivery status is updated to `delivered`, THE System SHALL deduct the quantity of each Delivery_Item from the `amount` field of the corresponding Product record.
2. IF deducting a Delivery_Item quantity would reduce a Product's Stock below zero, THEN THE System SHALL reject the status update and return a descriptive error message.
3. THE System SHALL perform all Stock deductions for a Delivery within a single database transaction, so that partial deductions do not occur on failure.

---

### Requirement 5: List and View Deliveries

**User Story:** As a warehouse manager, I want to view all deliveries and their details, so that I can monitor the status of outbound shipments.

#### Acceptance Criteria

1. THE Delivery_Controller SHALL provide an index view listing all Deliveries with their ID, Customer name, Delivery_Status, destination address, Creator name, and creation date.
2. WHEN a Creator views the Delivery index, THE System SHALL support filtering Deliveries by Delivery_Status.
3. WHEN a Creator selects a Delivery from the index, THE System SHALL display a detail view showing all Delivery_Items with product name, quantity, and unit price, along with the full Delivery record.
4. THE System SHALL use DataTables for the Delivery index listing, consistent with the existing product and customer index views.

---

### Requirement 6: Edit and Cancel a Delivery

**User Story:** As a warehouse manager, I want to edit or cancel a pending delivery, so that I can correct mistakes before a shipment goes out.

#### Acceptance Criteria

1. WHEN a Creator edits a Delivery with status `pending`, THE Delivery_Controller SHALL allow updating the Customer, destination address, and Delivery_Items.
2. IF a Creator attempts to edit a Delivery with status `in_transit`, `delivered`, or `cancelled`, THEN THE Delivery_Controller SHALL deny the edit and return an error message.
3. WHEN a Creator removes a Delivery_Item from a `pending` Delivery, THE System SHALL delete the Delivery_Item record without affecting Product Stock.
4. WHEN a Creator cancels a Delivery, THE System SHALL set the Delivery_Status to `cancelled` and prevent further edits.

---

### Requirement 7: Authorization and Access Control

**User Story:** As a system administrator, I want delivery management to be restricted to authenticated and authorized users, so that only permitted staff can create or modify deliveries.

#### Acceptance Criteria

1. THE System SHALL restrict all Delivery routes to users authenticated via the `auth` middleware.
2. THE System SHALL restrict all Delivery routes to users authorized via the `admin` middleware, consistent with existing route protection in the application.
3. IF an unauthenticated user attempts to access a Delivery route, THEN THE System SHALL redirect the user to the login page.
4. WHEN a Creator views or modifies a Delivery, THE System SHALL record the Creator's User ID on the Delivery record.
