Knowledge Sources
```
Ok, I have built a module for Domains, now I want to expand it by including the knowledge sources. 
Knowledge sources that I want to support are: 
- Code base
- Database
- API Documentation
  
Code base is the first class citizen, as it will provide a context for Database and API

## Configuration
- Code base is configured by giving the repository access (SSH only git link from Github, Gitlab or Bitbucket) and a set of ssh credentials and main / master branch is to be specified.
- Database is provided by supplying the DDL file (not DB access, I don't want it)
- API Documentation - I need to think about it, root catalogue of their online docs to crawl.

Let's rubber duck this. Maybe I am wrong about some of the assumptions.
The underlying background mechanics must work in the following fashion: 
- Code base should pull the latest code for analysis. As code evolves deltas on main branch are further analysed. 
- Database is evolved by running migrations against it. 
- API Documentation is crawled routinely for any API spec updates.

```


```
Ok, points granted. 
- Code base should not be a first class citizen but must maintain strong association with the database (if necessary)
- You are right about the case where multiple code bases may point to the same database. That would also assume that some of the tables can only be described by a certain codebase. If we have two projects - one dealing with users and another with worksites - worksite tables can only be described by reading the worksites code. So we need to re-think on how do we setup the database. 
I think one way to do it, is having providing the initial DDL and then running latest migrations against it? Knowledge database should maintain it's own version of the DB. Or we provide the connection and end user maintains his own server with the latest schema. 
- I am completely OPEN on how we deal with ingesting API documentation. Suggest your own flow, preferrably as automated as possible.
```





```
You are a senior Laravel engineer working inside an existing Laravel 10+ app.

## Context

We already have:

- A **Domain** module implemented (routes, controllers, views) that manages:
  - `domains` table
  - `App\Models\Domain` model

- The following tables & models already exist (do NOT alter their structure in this task):
  - `domains`
  - `knowledge_sources`
  - `domain_knowledge_source`
  - `knowledge_entity_types`
  - `knowledge_entities`
  - (Optionally: `knowledge_source_relation_types`, `knowledge_source_relations` – but you don’t need to touch them for this task.)

This task is ONLY about adding **CRUD for knowledge sources under a domain**, to configure:

- Codebase sources
- Database sources

No mechanics for cloning repos, running git commands, or introspecting DB schemas should be implemented yet. We are only building the configuration layer + UI around it.

---

## KnowledgeSource model recap (do not change table structure)

The `knowledge_sources` table already looks conceptually like this:

- `id` (bigint, PK)
- `type` (enum/string: `codebase` or `database` in v1)
- `name` (string)
- `slug` (string, unique)
- `description` (text, nullable)
- `config` (json, nullable)
- `is_active` (boolean, default true)
- `created_at`, `updated_at`

There is a pivot table `domain_knowledge_source`:

- `id`
- `domain_id`
- `knowledge_source_id`
- timestamps
- unique(domain_id, knowledge_source_id)

And model relationships:

- `Domain`:
  - `knowledgeSources(): BelongsToMany(KnowledgeSource::class, 'domain_knowledge_source')`

- `KnowledgeSource`:
  - `domains(): BelongsToMany(Domain::class, 'domain_knowledge_source')`
  - `config` is cast to `array` (if not, you may add the cast in this task).

Do NOT change migrations for these tables. Use them as-is.

---

## Goal of this task

Under the scope of a given **Domain**, implement full CRUD for **KnowledgeSource** configuration:

- List knowledge sources belonging to a domain
- Create a new knowledge source under a domain
- Edit/update a knowledge source under a domain
- Delete a knowledge source from a domain (and clean up the pivot)

Only two `knowledge_sources.type` values must be supported in v1:

- `codebase`
- `database`

Each type has a different `config` shape, described below.

No external APIs / API docs in v1.

---

## Configuration shapes (VERY IMPORTANT)

### 1) Codebase knowledge source (type = `codebase`)

This represents a git repository tracked over SSH.

The `config` JSON MUST support the following keys:

json
{
  "git_url": "git@github.com:org/repo.git",
  "branch": "main",
  "ssh_public_key": "-----BEGIN PUBLIC KEY-----\n...\n-----END PUBLIC KEY-----\n",
  "ssh_private_key": "-----BEGIN OPENSSH PRIVATE KEY-----\n...\n-----END OPENSSH PRIVATE KEY-----\n"
}

Notes:

- **Auth method** is always SSH in v1 (no HTTP/S tokens etc.).
    
- `git_url` is always an SSH URL (e.g. GitHub/GitLab/Bitbucket).
    
- `branch` defaults to `"main"` if not provided.
    
- For v1, both `ssh_public_key` and `ssh_private_key` are stored in the `config` JSON.
    
    - (Security hardening / secret storage will be a future concern; don’t over-engineer that now.)
        
- No `include` / `exclude` patterns.
    
- No `path_in_repo` (monorepo subdirs) in v1.
    

### 2) Database knowledge source (type = `database`)

This represents a remote **MySQL** database that the operator maintains. We only connect read-only (in the future) and introspect schema via `INFORMATION_SCHEMA`.

The `config` JSON MUST support the following keys:

{
  "driver": "mysql",
  "host": "db.example.com",
  "port": 3306,
  "database": "app_prod",
  "username": "readonly_user",
  "password": "plain_or_encrypted_here",
  "ssl": false
}
Notes:

- v1 supports only MySQL. `driver` should be `"mysql"` (could be validated).
    
- These values are configuration only. No actual DB connections should be implemented in this task.
    
- `password` will be stored in `config` JSON in v1 (we can add encryption/casting later).
  
We want to manage Knowledge Sources **within the scope of a Domain**, e.g.:

- `/domains/{domain}/manage` - list of knowledge sources
- `/domains/{domain}/knowledge-sources/create`
- `/domains/{domain}/knowledge-sources/{knowledgeSource}/edit`
    
- etc.
    

### 1) Index screen (per domain)

Under a Domain detail page or nested route, add an index screen that:
- Lists all knowledge sources linked to that domain.
    - Show columns:
        - Name
        - Type (Codebase / Database)
        - Short description
        - Active/inactive flag
    - Actions:
        - Edit
            
        - Delete (with confirmation)
            
- Provides a button: “Add Knowledge Source” which goes to the create form.
    

### 2) Create / Edit forms

Forms are **type-aware**:

- At the top, user chooses `type`:
    
    - `Codebase`
        
    - `Database`
        
- Depending on type, show different config fields.
    

#### Common fields:

- `name` (required)
    
- `slug` (required, unique; can be auto-slugged from name on the frontend)
    
- `description` (optional)
    
- `is_active` (checkbox)
    

#### For type = `codebase`:

Show fields:

- `git_url` (text input, required)
    
- `branch` (text input, optional, default “main”)
    
- `ssh_public_key` (textarea, required)
    
- `ssh_private_key` (textarea, required)
    

These are persisted into `config` JSON with the exact keys defined above.

#### For type = `database`:

Show fields:

- `host` (text input, required)
    
- `port` (number input, default 3306)
    
- `database` (text input, required)
    
- `username` (text input, required)
    
- `password` (password input, required in create; optional in update if unchanged)
    
- `ssl` (boolean, checkbox)
    

Persist to `config` JSON with the exact keys defined above, plus `"driver": "mysql"`.

### 3) Validation

Use Form Request classes for both **store** and **update**.

Validation rules:

- `name`: required, string, max:255
    
- `slug`: required, string, max:255, unique in `knowledge_sources.slug`
    
- `type`: required, in:`codebase,database`
    

For `codebase` type:

- `git_url`: required, string
    
- `branch`: nullable/string, default to `main` if empty
    
- `ssh_public_key`: required, string
    
- `ssh_private_key`: required on create; optional on update but if provided, overwrite the stored one
    

For `database` type:

- `host`: required, string
    
- `port`: required, integer
    
- `database`: required, string
    
- `username`: required, string
    
- `password`: required on create; optional on update but if provided, overwrite
    
- `ssl`: boolean
    

On update, if the user leaves password/private key fields blank, do NOT null them; keep existing ones.

---

## Architecture & files to implement

Use standard Laravel, Blade & controllers (no Livewire or Inertia unless you want to and it stays simple).

If you prefer, you can name the controller `DomainKnowledgeSourceController` or `KnowledgeSourceController` in a `Domain` namespace. Just be consistent.)

### 2) Controller: DomainKnowledgeSourceController

Create a controller, e.g.:

- `App\Http\Controllers\DomainKnowledgeSourceController`
    

Responsibilities:

- `index(Domain $domain)`:
    
    - Load domain’s knowledgeSources with pagination
        
    - Return a view with the list
        
- `create(Domain $domain)`:
    
    - Show a form to create a new knowledge source for that domain
        
- `store(Domain $domain, StoreKnowledgeSourceRequest $request)`:
    
    - Validate input
        
    - Create `KnowledgeSource`
        
    - Attach it to the domain via pivot (`$domain->knowledgeSources()->attach($ksId)`)
        
    - Redirect back to the index with success message
        
- `edit(Domain $domain, KnowledgeSource $knowledgeSource)`:
    
    - Ensure the knowledgeSource belongs to this domain (abort 404 or 403 if not)
        
    - Show edit form prefilled with config
        
- `update(Domain $domain, KnowledgeSource $knowledgeSource, UpdateKnowledgeSourceRequest $request)`:
    
    - Validate input
        
    - Update `KnowledgeSource` (including `config` JSON)
        
    - Redirect back with success message
        
- `destroy(Domain $domain, KnowledgeSource $knowledgeSource)`:
    
    - Detach from the domain and (for v1) also delete the `KnowledgeSource` record itself
        
    - Redirect back with success message
        

Optional: put any creation/update logic into a small service class (see below), but keep it simple.

### 3) Form Requests

Implement:

- `App\Http\Requests\StoreKnowledgeSourceRequest`
    
- `App\Http\Requests\UpdateKnowledgeSourceRequest`
    

They should:

- Validate common fields
    
- Based on `type`, validate the relevant config fields
    
- Transform the validated data into:
    
    - attributes for `KnowledgeSource` (`name`, `slug`, `type`, `description`, `is_active`)
        
    - a `config` array with the correct shape
        
- You can provide helper method(s) like `configPayload()` on the request to build the config array.
    

### 4) Service (optional but preferred): KnowledgeSourceService

Implement a small service class to keep the controller thin, e.g.:

- `App\Services\KnowledgeSourceService`
    

With methods like:

- `public function createForDomain(Domain $domain, array $data): KnowledgeSource`
    
- `public function updateForDomain(Domain $domain, KnowledgeSource $knowledgeSource, array $data): KnowledgeSource`
    
- `public function deleteFromDomain(Domain $domain, KnowledgeSource $knowledgeSource): void`
    

Where `$data` includes both base fields and `config` array.

This service should handle:

- building the `config` array
    
- dealing with “keep existing ssh_private_key/password if blank on update”
    

But keep it very straightforward and readable.

### 5) Views

Create Blade views under something like:

- `resources/views/domains/knowledge-sources/index.blade.php`
    
- `resources/views/domains/knowledge-sources/create.blade.php`
    
- `resources/views/domains/knowledge-sources/edit.blade.php`
    
- (And optionally a shared `_form.blade.php` partial for the create/edit forms.)
    

Styling:

- You can assume Tailwind is available, but keep styles minimal.
    
- Make the type-specific fields show/hide based on selected type.
    
    - A simple approach: use Alpine.js (if already present) or plain JavaScript to toggle sections.
        

---

## Important constraints

- Do NOT implement any actual git operations (no `git clone`, no background jobs).
    
- Do NOT implement any actual MySQL connection / introspection logic.
    
- This task is **only** for configuration CRUD (forms + controllers + views + basic service).
    
- Do not modify existing migrations for `knowledge_sources` or any other tables.
    
- Do not introduce new tables.
    

When you’re done, I should be able to:

1. Go to a domain’s “Knowledge Sources” page.
    
2. Add a new **Codebase** source with SSH details.
    
3. Add a new **Database** source with MySQL connection details.
    
4. Edit/update those configurations.
    
5. Delete them from the domain.
    

All without errors, using conventional Laravel 10 patterns.
```
