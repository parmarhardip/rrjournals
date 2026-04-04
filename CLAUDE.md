# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a custom WordPress theme called "RRJournals Theme" based on the Twenty Seventeen theme. It's designed for academic journals and includes functionality for managing research papers, journal issues, conference proceedings, and academic content.

## Core Architecture

### Custom Post Types
The theme registers several custom post types in `functions.php`:
- `hr_em` - Editorial management
- `rr_issue` - Journal issues
- `rr_submited_paper` - Submitted papers
- `rr_cv` - Curriculum vitae/profiles
- `rr_special_issue` - Special journal issues
- `rr_sp_paper_list` - Special issue paper lists
- `rr_cp_post` - Conference proceeding posts

### Template Hierarchy
- Page templates: `page-*.php` files for specific page types (submit-paper, current-issue, journal-reviewers, etc.)
- Single templates: `single-*.php` files for custom post types
- Archive templates: `archive-*.php` files for custom post type archives
- Template parts in `/template-parts/` organized by type (page/, post/, header/, footer/, navigation/)

### Key Directories
- `/inc/` - Core theme functions and includes
- `/assets/` - CSS, JS, and image assets
- `/template-parts/` - Reusable template components
- `/hr-dev/` - HR development specific functionality
- `/swansong/` - Additional functionality modules

### Theme Functions Structure
The main `functions.php` file contains:
- Theme setup and WordPress feature support
- Custom post type registrations
- Asset enqueuing (CSS/JS)
- Custom functions for journal management
- ACF (Advanced Custom Fields) integration

### Asset Management
Assets are enqueued via WordPress standards in the `twentyseventeen_scripts()` function:
- Fonts from Google Fonts
- Theme stylesheet (`style.css`)
- JavaScript files from `/assets/js/`
- Conditional CSS for different browsers and color schemes

## Development Workflow

### File Structure
- Main theme files are in the root directory
- Include files are organized in `/inc/`
- Template parts follow WordPress hierarchy in `/template-parts/`
- Custom functionality is modularized in separate directories

### Customization Areas
- Theme customizer settings in `inc/customizer.php`
- Custom header functionality in `inc/custom-header.php`
- Template functions in `inc/template-functions.php` and `inc/template-tags.php`
- Color patterns in `inc/color-patterns.php`

### WordPress Integration
- Uses WordPress hooks extensively (`add_action`, `add_filter`)
- Follows WordPress coding standards
- Integrates with Advanced Custom Fields (ACF)
- Supports WordPress customizer
- Includes RTL language support

## Key Features

### Academic Journal Functionality
- Paper submission system
- Issue management (current, past, special issues)
- Reviewer management
- Conference proceedings
- Certificate generation/viewing
- Book downloads
- Editorial board management

### Content Management
- Custom taxonomies for categorizing academic content
- Meta boxes for additional content fields
- Search functionality for papers and issues
- CAPTCHA integration for forms

## Development Notes

- Theme is based on Twenty Seventeen but heavily customized for academic use
- Uses WordPress template hierarchy extensively
- Includes custom CAPTCHA implementation
- Has specialized templates for different journal content types
- Integrates with external academic systems and workflows