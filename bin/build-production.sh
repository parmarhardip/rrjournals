#!/bin/bash

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Config
THEME_NAME="rrjournal"
BUILD_DIR="build"
OUTPUT_DIR="bin/output"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
ZIP_NAME="${THEME_NAME}-production-${TIMESTAMP}.zip"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_ROOT="$(dirname "$SCRIPT_DIR")"

echo -e "${BLUE}🚀 Building Production Package${NC}"
echo -e "${BLUE}Theme Root: ${THEME_ROOT}${NC}"

cd "$THEME_ROOT"

# Clean previous build
[ -d "$BUILD_DIR" ] && rm -rf "$BUILD_DIR"

# Ensure output directory exists
mkdir -p "$OUTPUT_DIR"

# Create build structure
mkdir -p "$BUILD_DIR/$THEME_NAME"

echo -e "${BLUE}📦 Copying theme files...${NC}"

# Copy directories safely
for dir in inc template-parts assets hr-dev swansong; do
    [ -d "$dir" ] && cp -r "$dir" "$BUILD_DIR/$THEME_NAME/"
done

# Copy root files
cp *.php *.css *.txt *.md "$BUILD_DIR/$THEME_NAME/" 2>/dev/null || true

# Optional migration script
if [ -f "../../../migrate-cfs-to-metaboxes.php" ]; then
    cp "../../../migrate-cfs-to-metaboxes.php" "$BUILD_DIR/$THEME_NAME/"
fi

echo -e "${YELLOW}🧹 Cleaning dev files...${NC}"

# Remove unwanted dirs
rm -rf "$BUILD_DIR/$THEME_NAME"/{.git,.gsd,bin,node_modules,.sass-cache} 2>/dev/null || true

# Remove unwanted files
rm -f "$BUILD_DIR/$THEME_NAME"/{.gitignore,.gitattributes,package.json,package-lock.json,gulpfile.js,webpack.config.js,composer.json,composer.lock} 2>/dev/null || true

# Cleanup junk
find "$BUILD_DIR/$THEME_NAME" -type f \( -name "*.log" -o -name "*.tmp" -o -name ".DS_Store" -o -name "Thumbs.db" \) -delete

# Update version
if [ -f "$BUILD_DIR/$THEME_NAME/style.css" ]; then
    sed -i.bak "s/Version: .*/Version: Production Build $TIMESTAMP/" "$BUILD_DIR/$THEME_NAME/style.css" 2>/dev/null || true
    rm -f "$BUILD_DIR/$THEME_NAME/style.css.bak"
fi

echo -e "${BLUE}📦 Creating zip...${NC}"

cd "$BUILD_DIR"
zip -r "../$OUTPUT_DIR/$ZIP_NAME" "$THEME_NAME" -q
cd "$THEME_ROOT"

# Optional: keep build OR remove
rm -rf "$BUILD_DIR"

FILE_SIZE=$(ls -lh "$OUTPUT_DIR/$ZIP_NAME" | awk '{print $5}')

echo -e "${GREEN}✅ Build completed!${NC}"
echo -e "${GREEN}📁 File: ${OUTPUT_DIR}/${ZIP_NAME}${NC}"
echo -e "${GREEN}📊 Size: ${FILE_SIZE}${NC}"