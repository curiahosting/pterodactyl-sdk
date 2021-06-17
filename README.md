# pterodactyl-sdk

## Supported Routes
### Client (/api/client)
- [ ] "GET /servers" List Servers
- [ ] "GET /permissions" Show Permissions
#### Account (/account)
- [ ] "GET /" Account Details
- [ ] "GET /two-factor" 2FA Details
- [ ] "POST /two-factor" Enable 2FA
- [ ] "DELETE /two-factor" Disable 2FA
- [ ] "PUT /email" Update Email
- [ ] "PUT /password" Update Password
- [ ] "GET /api-keys" List API Keys
- [ ] "POST /api-keys" Create API Key
- [ ] "DELETE /api-keys/{identifier}" Delete API Key

#### Server (/servers/{server})
- [ ] "GET /" Server Details
- [ ] "GET /websocket" Console Details
- [ ] "GET /resources" Resource Usage
- [ ] "POST /command" Send Command
- [ ] "POST /power" Change Power State
##### Databases (/databases)
- [ ] "GET /" List Databases
- [ ] "POST /" Create Database
- [ ] "POST /{database}/rotate-password" Rotate Password
- [ ] "DELETE /{database}" Delete Database
##### File Manager (/files)
- [ ] "GET /" List Files
- [ ] "GET /contents" Get File Contents
- [ ] "GET /download" Download File
- [ ] "PUT /rename" Rename File
- [ ] "POST /copy" Copy File
- [ ] "POST /write" Write File
- [ ] "POST /compress" Compress File
- [ ] "POST /decompress" Decompress File
- [ ] "POST /delete" Delete File
- [ ] "POST /create-folder" Create Folder
- [ ] "GET /upload" Upload File
##### Schedules (/schedules)
- [ ] "GET /" List Schedules
- [ ] "POST /" Create Schedule
- [ ] "GET /{schedule}" Schedule Details
- [ ] "POST /{schedule}" Update Schedule
- [ ] "DELETE /{schedule}" Delete Schedule
- [ ] "POST /{schedule}/tasks" Create Task
- [ ] "POST /{schedule}/tasks/{task}" Update Task
- [ ] "DELETE /{schedule}/tasks/{task}" Delete Task
##### Network (/network)
- [ ] "GET /allocations" List Allocations
- [ ] "POST /allocations" Assign Allocation
- [ ] "POST /allocations/{allocation}" Set Allocation Note
- [ ] "POST /allocations/{allocation}/primary" Set Primary Allocation
- [ ] "DELETE /allocations/{allocation}" Unassign Allocation
##### Users (/users)
- [ ] "GET /" List Users
- [ ] "POST /" Create User
- [ ] "GET /{subuser}" User Details
- [ ] "POST /{subuser}" Update User
- [ ] "DELETE /{subuser}" Delete User
##### Backups (/backups)
- [ ] "GET /" List Backups
- [ ] "POST /" Create Backup
- [ ] "GET /{backup}" Backup Details
- [ ] "GET /{backup}/download" Download Backup
- [ ] "DELETE /{backup}" Delete Backup
##### Startup (/startup)
- [ ] "GET /" List Variables
- [ ] "POST /variable" Update Variable
##### Setings (/settings)
- [ ] "POST /rename" Rename Server
- [ ] "POST /reinstall" Rename Server
### Application (/api/application)
#### Users (/users)
- [ ] "GET /" List Users
- [ ] "GET /{user}" User Details
- [ ] "GET /external/{external_id}" User Details
- [ ] "POST /" Create User
- [ ] "PATCH /" Update User
- [ ] "DELETE /{user}" Delete User
#### Nodes (/nodes)
- [x] "GET /" List Nodes
- [ ] "GET /{node}" Node Details
- [ ] "GET /{node}/configuration" Node Configuration
- [ ] "POST /" Create Note
- [ ] "PATCH /{node}" Update Node
- [ ] "DELETE /{node}" Delete Node
##### Allocations (/{node}/allocations)
- [ ] "GET /" List Allocations
- [ ] "POST /" Create Allocation
- [ ] "DELETE /{allocation}" Delete Allocation
#### Locations (/locations)
- [ ] "GET /" List Locations
- [ ] "GET /{location}" Location Details
- [ ] "POST /" Create Location
- [ ] "PATCH /" Update Location
- [ ] "DELETE /{location}" Delete Location
#### Servers (/servers)
- [x] "GET /" List Servers
- [x] "GET /{server}" Server Details
- [x] "GET /external/{external_id}" Server Details
- [x] "PATCH /{server}/details" Update Details
- [x] "PATCH /{server}/build" Update Build
- [x] "PATCH /{server}/startup" Update Startup
- [ ] "POST /" Create Server
- [x] "POST /{server}/suspend" Suspend Server
- [x] "POST /{server}/unsuspend" Unsuspend Server
- [x] "POST /{server}/reinstall" Reinstall Server
- [ ] "DELETE /{server}" Delete Server
- [ ] "DELETE /{server}/{force?}" ForceDelete Server
##### Databases (/{server}/databases)
- [ ] "GET /" List Databases
- [ ] "GET /{database}" Database Details
- [ ] "POST /" Create Database
- [ ] "POST /{database}/reset-password" Reset Password
- [ ] "DELETE /{database}" Delete Database
#### Nests (/nests)
- [ ] "GET /" List Nests
- [ ] "GET /{nest}" Nest Details
##### Eggs (/eggs)
- [ ] "GET /" List Eggs
- [ ] "GET /{egg}" Egg Details
