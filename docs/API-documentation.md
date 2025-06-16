## **`Base URL`**

#### **`/api/v1`**

## **`1. Authentication Endpoints`**

### **`1.1. Sign In User`**

* #### **`URL: /api/v1/auth/sign-in`**

* #### **`Method: POST`**

* #### **`Description: Authenticates a user and provides an access token.`**

#### **`Request Body (JSON):`** **`{`**

####     **`"email": "user@example.com",`**

####     **`"password": "your_password"`**

#### **`}`**

* #### **`Validation Rules (SignInUserRequest):`**

  * #### **`email: required | email (Must be a valid email address)`**

  * #### **`password: required (Must be provided)`**

### **`1.2. Sign Up User`**

* #### **`URL: /api/v1/auth/sign-up`**

* #### **`Method: POST`**

* #### **`Description: Registers a new user.`**

#### **`Request Body (JSON): (Assuming a similar structure to Sign-in but might include 'name' and 'password_confirmation')`** **`{`**

####     **`"name": "John Doe",`**

####     **`"email": "newuser@example.com",`**

####     **`"password": "new_password",`**

####     **`"password_confirmation": "new_password"`**

#### **`}`**

* #### **`Validation Rules: (Assuming a SignUpUserRequest, which was not provided, but typically includes:)`**

  * #### **`name: required | string | max:255`**

  * #### **`email: required | email | unique:users`**

  * #### **`password: required | string | min:6 | confirmed`**

### **`1.3. Update User Profile`**

* #### **`URL: (Assuming a route like /api/v1/auth/user/profile or /api/v1/user/{id})`**

* #### **`Method: (Typically PUT or PATCH for updates. Based on your UpdateUserProfileRequest, it's likely a PUT or PATCH to a user-specific endpoint, possibly for the authenticated user, hence no {id} in the URL in the route file provided.)`**

* #### **`Description: Updates the authenticated user's profile information.`**

* #### **`Middleware: auth:api`**

#### **`Request Body (JSON):`** **`{`**

####     **`"name": "Updated Name",`**

####     **`"email": "updated_email@example.com",`**

####     **`"password": "new_password",`**

####     **`"password_confirmation": "new_password"`**

#### **`}`** ***`Note: password and password_confirmation are optional if you're not changing the password.`***

* #### **`Validation Rules (UpdateUserProfileRequest):`**

  * #### **`name: required | string | max:255`**

  * #### **`email: required | string | email | max:255 | unique:users,email,{authenticated_user_id} (Must be a valid email and unique, except for the current user's email)`**

  * #### **`password: required | string | min:6 | confirmed (If password is present in the request, it must be at least 6 characters long and match password_confirmation). This field is nullable if password is not present in the request.`**

## **`2. Task Endpoints`**

* #### **`Middleware: auth:api (All task endpoints require authentication)`**

### **`2.1. Get All Tasks`**

* #### **`URL: /api/v1/tasks`**

* #### **`Method: GET`**

* #### **`Description: Retrieves a list of tasks for the authenticated user.`**

* #### **`Request Parameters: None`**

* #### **`Validation Rules: None (typically, but might include optional query parameters for filtering/pagination)`**

### **`2.2. Create a New Task`**

* #### **`URL: /api/v1/tasks`**

* #### **`Method: POST`**

* #### **`Description: Creates a new task for the authenticated user.`**

* #### **`Middleware: throttle:task-create (Rate-limited to prevent excessive task creation)`**

#### **`Request Body (JSON): (Assuming a CreateTaskRequest, which was not provided)`** **`{`**

####     **`"title": "My New Task",`**

####     **`"description": "This is a detailed description of the task.",`**

####     **`"due_date": "2025-12-31"`**

#### **`}`**

* #### 

* #### **`Validation Rules: (Assuming a CreateTaskRequest, which was not provided, but typically includes:)`**

  * #### **`title: required | string | max:255`**

  * #### **`description: nullable | string`**

  * #### **`due_date: nullable | date`**

### 

### **`2.3. Update an Existing Task`**

* #### **`URL: /api/v1/tasks/{id}`**

* #### **`Method: PUT`**

* #### **`Description: Updates the details of a specific task.`**

* #### **`URL Parameters:`**

  * #### **`id: The ID of the task to update.`**

#### **`Request Body (JSON): (Assuming an UpdateTaskRequest, which was not provided, but similar to CreateTaskRequest)`** **`{`**

####     **`"title": "Updated Task Title",`**

####     **`"description": "New description for the task."`**

#### **`}`**

* #### 

* #### **`Validation Rules: (Assuming an UpdateTaskRequest, which was not provided, but typically includes:)`**

  * #### **`title: nullable | string | max:255 (Fields are often nullable for PUT, as you might only update a subset)`**

  * #### **`description: nullable | string`**

  * #### **`due_date: nullable | date`**

### **`2.4. Update Task Status`**

* #### **`URL: /api/v1/tasks/{id}`**

* #### **`Method: PATCH`**

* #### **`Description: Updates the status of a specific task (e.g., 'completed', 'pending').`**

* #### **`URL Parameters:`**

  * #### **`id: The ID of the task whose status is to be updated.`**

#### **`Request Body (JSON): (Assuming an UpdateTaskStatusRequest, which was not provided)`** **`{`**

####     **`"status": "completed"`**

#### **`}`**

* #### 

* #### **`Validation Rules: (Assuming an UpdateTaskStatusRequest, which was not provided, but typically includes:)`**

  * #### **`status: required | string | in:pending,completed,etc. (Enum of allowed statuses)`**

### **`2.5. Delete a Task`**

* #### **`URL: /api/v1/tasks/{id}`**

* #### **`Method: DELETE`**

* #### **`Description: Deletes a specific task.`**

* #### **`URL Parameters:`**

  * #### **`id: The ID of the task to delete.`**

* #### **`Request Parameters: None`**

* #### **`Validation Rules: None (typically)`**

#### 

#### 

#### 

