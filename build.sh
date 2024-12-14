#!/bin/bash

# 1. ติดตั้ง npm dependencies
npm install

# 2. สร้างไฟล์ assets (CSS/JS) สำหรับ production
npm run build

# 3. ติดตั้ง PHP dependencies
composer install --no-dev --optimize-autoloader
