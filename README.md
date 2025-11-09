# 🧾 Multi Branch System API

### Centralized backend for managing multiple branches, balances, and transactions — built with **Laravel 12**, following **service–repository architecture**, **JWT authentication**, and **real-time broadcasting**.

---

## 🚀 Overview

The **Multi Branch System API** is a backend system designed for organizations that manage multiple branches.  
Each branch has its own balance and transactions (income & expense).  
The system provides **role-based access**, **real-time updates**, and a **clean service-repository architecture** for scalability and maintainability.

---

## ⚙️ Tech Stack

| Layer | Technology |
|-------|-------------|
| Framework | Laravel 12 (PHP 8.4) |
| Authentication | JWT (tymon/jwt-auth) |
| Real-time Updates | Laravel Reverb |
| Database | PostgreSQL |
| Caching | Redis / File Cache |
| Architecture | Service + Repository Pattern |
| Testing | Postman |
| Deployment | GitHub + VPS / Render / Railway |

---

## 🧱 System Modules

| Module | Description |
|---------|--------------|
| **Auth** | JWT-based authentication (register, login, logout, refresh) |
| **Branch** | CRUD operations with policy-based admin control |
| **Transaction** | Income/expense management with auto-balance updates |
| **Balance** | Real-time balance management per branch |
| **Activity Log** | Automatically tracks user actions |
| **Broadcasting** | Real-time transaction events using Reverb |

---

## 🔐 Roles

| Role | Permissions |
|------|--------------|
| **Admin** | Manage all branches and transactions |
| **User** | Access only their assigned branch and related transactions |

---

## ⚡ Key Features

✅ JWT Authentication (Login / Register / Logout / Refresh)  
✅ Repository + Service Layer (Clean Architecture)  
✅ Branch-based Balance Updates  
✅ Real-time Broadcasting (Laravel Reverb)  
✅ Authorization via Policies (Admin vs User)  
✅ Caching with Redis or File Cache  
✅ Exception Handling with clear JSON responses  

---

## 🧰 Installation

1️⃣ **Clone & enter project**
```bash
git clone https://github.com/<yourusername>/multi_branch_system-api.git
cd multi_branch_system-api
