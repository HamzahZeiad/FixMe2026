# Module2 Models Documentation

## 📋 **Model Structure Overview**

Based on the UML diagram provided, Module2 now has a complete set of models that handle inquiry submission, assignment, and management functionality.

## 🏗️ **Core Models**

### **1. Main Entity Models**

#### **PublicUser** (`App\Models\PublicUser`)
- **Purpose**: Represents public users who submit inquiries
- **Key Relationships**:
  - `inquiries()` - All inquiries submitted by this user
  - `pendingInquiries()` - Pending inquiries only
  - `completedInquiries()` - Completed inquiries only
- **Methods**:
  - `getInquiryStats()` - Get inquiry statistics for the user

#### **Administrator** (`App\Models\Admin`)
- **Purpose**: Represents admin users who manage inquiries and assignments
- **Key Relationships**:
  - `managedInquiries()` - All inquiries managed by this admin
  - `createdAssignments()` - All assignments created by this admin
  - `responsibleAssignments()` - All assignments this admin is responsible for
  - `progressNotes()` - All progress notes added by this admin
  - `statusChanges()` - All status changes made by this admin
- **Methods**:
  - `getPerformanceStats()` - Get admin performance statistics
  - `calculateAverageResolutionTime()` - Calculate average resolution time
  - `getInquiriesRequiringAttention()` - Get inquiries needing immediate attention

#### **Agency** (`App\Models\Agency`)
- **Purpose**: Represents agencies that handle assigned inquiries
- **Key Relationships**:
  - `assignedInquiries()` - All inquiries assigned to this agency
  - `assignments()` - Assignment details for this agency
  - `pendingAssignments()` - Pending assignments only
  - `inProgressAssignments()` - In-progress assignments only
  - `completedAssignments()` - Completed assignments only
  - `overdueAssignments()` - Overdue assignments only
- **Methods**:
  - `getWorkloadStats()` - Get agency workload statistics
  - `calculateCompletionRate()` - Calculate completion rate percentage
  - `calculateAverageCompletionTime()` - Calculate average completion time

### **2. Module2 Specific Models**

#### **Inquiry** (`App\Models\Module2\Inquiry`)
- **Purpose**: Core inquiry entity for Module2
- **Key Relationships**:
  - `publicUser()` - The user who submitted the inquiry
  - `agency()` - The agency assigned to handle the inquiry
  - `administrator()` - The admin managing the inquiry
  - `assignedInquiry()` - Assignment details
  - `attachments()` - All file attachments
  - `progressNotes()` - All progress notes
  - `statusHistory()` - All status change history
- **Scopes**:
  - `byStatus()`, `byPriority()`, `byUser()`, `byAgency()`
  - `pending()`, `assigned()`, `completed()`
- **Methods**:
  - `isOverdue()` - Check if inquiry is overdue
  - `getAgeInDays()` - Get inquiry age in days
  - `getResolutionTimeInDays()` - Get resolution time

#### **AssignedInquiry** (`App\Models\Module2\AssignedInquiry`)
- **Purpose**: Junction model for inquiry assignments with detailed tracking
- **Key Relationships**:
  - `inquiry()` - The assigned inquiry
  - `agency()` - The assigned agency
  - `assignedBy()` - The admin who made the assignment
  - `admin()` - The responsible admin
- **Scopes**:
  - `byStatus()`, `byPriority()`, `overdue()`
- **Methods**:
  - `isOverdue()` - Check if assignment is overdue
  - `getDaysRemaining()` - Get days remaining until due date

### **3. Supporting Models**

#### **InquiryAttachment** (`App\Models\Module2\InquiryAttachment`)
- **Purpose**: File attachments for inquiries
- **Key Features**:
  - Polymorphic uploader tracking (user/admin/agency)
  - File type classification (evidence, documents, images)
  - Size and format validation
- **Methods**:
  - `getFileSizeFormatted()` - Human readable file size
  - `isImage()`, `isDocument()` - File type checks

#### **InquiryProgressNote** (`App\Models\Module2\InquiryProgressNote`)
- **Purpose**: Progress notes and updates for inquiries
- **Key Features**:
  - Different note types (progress, internal, customer-facing)
  - Action tracking with due dates
  - Visibility controls
- **Scopes**:
  - `internal()`, `visibleToUser()`, `requiresAction()`, `overdueActions()`

#### **InquiryStatusHistory** (`App\Models\Module2\InquiryStatusHistory`)
- **Purpose**: Complete audit trail of status changes
- **Key Features**:
  - Automatic and manual change tracking
  - Duration calculations between status changes
  - Change reason and comments
- **Methods**:
  - `getStatusDurationFormatted()` - Human readable duration
  - `isRecent()` - Check if change was recent

#### **User** (`App\Models\Module2\User`)
- **Purpose**: Unified interface for all user types in Module2
- **Key Features**:
  - Centralized user access across types
  - Cross-user-type search functionality
  - Activity tracking and statistics
- **Static Methods**:
  - `getUserByType()` - Get user by type and ID
  - `searchAllUsers()` - Search across all user types
  - `getUserActivitySummary()` - Get activity summary for any user type

## 🔗 **Relationship Diagram**

```
PublicUser
    └── inquiries() → Inquiry
                         ├── agency() → Agency
                         ├── administrator() → Admin
                         ├── assignedInquiry() → AssignedInquiry
                         ├── attachments() → InquiryAttachment
                         ├── progressNotes() → InquiryProgressNote
                         └── statusHistory() → InquiryStatusHistory

Agency
    ├── assignedInquiries() → Inquiry
    └── assignments() → AssignedInquiry
                           └── inquiry() → Inquiry

Admin
    ├── managedInquiries() → Inquiry
    ├── createdAssignments() → AssignedInquiry
    └── responsibleAssignments() → AssignedInquiry
```

## 📊 **Key Features**

### **Statistics & Analytics**
- User inquiry statistics
- Agency workload metrics
- Admin performance tracking
- Resolution time calculations
- Completion rate analysis

### **Search & Filtering**
- Cross-model search capabilities
- Status-based filtering
- Priority-based filtering
- Date range filtering
- User-specific filtering

### **Audit & Tracking**
- Complete status change history
- File attachment tracking
- Progress note timeline
- Assignment audit trail

### **Performance Monitoring**
- Overdue detection
- SLA monitoring
- Workload distribution
- Response time tracking

## ✅ **Model Validation**

All models have been created with:
- ✅ No syntax errors
- ✅ Proper relationships as per UML diagram
- ✅ Comprehensive method coverage
- ✅ Scope functions for common queries
- ✅ Statistical and analytical methods
- ✅ Proper casting and data handling

The Module2 model structure is now complete and ready for integration with the controllers and database migrations.
