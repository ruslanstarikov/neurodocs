# Ingestion of the database
Following three layer architecture

## 1. Structural facts
``
“What is this table technically?”
``
Extracted data:
- Table name
- Columns (name, type, nullable, default)
- Primary key, indexes
- Foreign keys and relationships
- Comments (if any)
Characteristics:
Derived only from the DB, no code involved 100% objective

Useful as the foundational graph, but not enough to understand meaning

## 2. Usage Layer
```
“How is this table used in code?”
```
- Which models are mapped to these tables
- Which raw queries are using it
- Which services, repositories, controllers interact with this table
- Which relationships appear in the ORM
- Which relationships appear in raw queries (sub-queries, joins)
- Where in the codebase these interactions live

## 3. Semantic Layer
- Table purpose in business language
- Domain meaning (“Admin users”, “Employee accounts”, “Customer invoices”)
- How it fits into workflows
- Common query patterns
- Important relationships
- Warnings (ambiguity, naming mismatches, legacy patterns)
