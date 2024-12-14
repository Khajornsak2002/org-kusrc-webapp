#!/bin/bash

# ติดตั้ง npm dependencies
npm install

# สร้าง assets (CSS/JS) สำหรับ production
npm run build

# ติดตั้ง PHP dependencies
composer install --no-dev --optimize-autoloader
