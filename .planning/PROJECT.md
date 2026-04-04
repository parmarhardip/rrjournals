# CFS to WordPress Meta Box Migration

## What This Is

A systematic migration project to replace Custom Field Suite (CFS) plugin with native WordPress custom meta boxes for the RRJournals academic website theme. This eliminates plugin dependency while preserving all existing functionality and data integrity for managing editorial boards, academic papers, conference proceedings, and book downloads.

## Core Value

All existing academic content and editorial data must remain fully functional and accessible after migration, with zero data loss and identical user experience.

## Requirements

### Validated

(None yet — ship to validate)

### Active

- [ ] Create WordPress custom meta boxes to replace all CFS field groups
- [ ] Develop repeater field functionality for complex nested loops
- [ ] Migrate all existing CFS data to WordPress meta format
- [ ] Update all template files to use WordPress meta functions instead of CFS()->get()
- [ ] Preserve file upload functionality and attachment relationships
- [ ] Maintain editorial board management with nested profile links
- [ ] Ensure academic paper citation formats continue working
- [ ] Support book management for HR development section
- [ ] Handle conference category image sliders
- [ ] Create data validation and rollback mechanisms
- [ ] Remove CFS plugin dependency safely
- [ ] Document new meta box usage for future maintenance

### Out of Scope

- Redesigning the administrative interface — keep existing workflow familiar
- Changing data structure beyond what's necessary for migration — maintain current organization
- Adding new functionality — focus purely on migration and equivalence
- Modifying front-end display — preserve exact visual presentation

## Context

### Current CFS Usage Analysis
- **4 major field groups** identified across the theme
- **32 unique fields** including complex nested loops
- **8 template files** using CFS functions
- **Most complex**: Editorial board with nested web profiles loop
- **File uploads**: PDF documents and cover images for academic content
- **Data types**: Text, textarea, file upload, URL fields, and complex repeater structures

### Technical Environment
- WordPress theme based on Twenty Seventeen
- Custom post types: hr_em, rr_issue, rr_submited_paper, rr_cv, rr_special_issue, rr_sp_paper_list, rr_cp_post
- Advanced Custom Fields plugin also present (used for conference category images)
- Academic journal functionality with citation formats (MLA, APA, Chicago, Harvard, Vancouver)

### Migration Challenges
- WordPress lacks native repeater fields requiring custom JSON storage solution
- Complex nested loops (editorial_board_members → ebm_web_profiles) need careful handling
- File attachment ID mapping during data migration
- Maintaining backward compatibility during transition period

## Constraints

- **Data integrity**: Zero data loss acceptable — must have rollback capability
- **Downtime**: Minimize site downtime during migration — staged approach required
- **User training**: Administrative interface changes must be minimal
- **WordPress compatibility**: Solution must work with current WordPress version and future updates
- **Performance**: New implementation should not be slower than CFS

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| JSON storage for repeater fields | WordPress lacks native repeater functionality, JSON provides flexible structure | — Pending |
| Phased migration approach | Reduces risk and allows testing at each stage | — Pending |
| Helper functions for data access | Abstracts complexity and provides clean API | — Pending |

## Evolution

This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd:transition`):
1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd:complete-milestone`):
1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state

---
*Last updated: 2026-04-04 after initialization*