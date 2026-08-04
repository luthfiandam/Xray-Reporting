<?php

namespace App\Constants;

class QueryConstants
{
    // ===== EAGER LOADING =====
    const WITH_ROLE = ['role'];
    const WITH_EQUIPMENT = ['equipment', 'equipment.location', 'equipment.equipmentType'];
    const WITH_CHECKLIST = ['checklistTemplate', 'checklistTemplate.items'];
    const WITH_USER = ['createdBy', 'assignedTo', 'approvedBy'];
    const WITH_WORK_ORDER = ['workOrder', 'workOrder.equipment', 'workOrder.equipment.location'];
    const WITH_RESULTS = ['checklistResults', 'measurementResults', 'evidences'];

    // ===== ORDERING =====
    const ORDER_LATEST = 'latest';
    const ORDER_OLDEST = 'oldest';
    const ORDER_ALPHABETIC = 'alphabetic';
    const ORDER_PRIORITY = 'priority';

    // ===== FILTERING =====
    const FILTER_STATUS = 'status';
    const FILTER_PRIORITY = 'priority';
    const FILTER_DATE_FROM = 'date_from';
    const FILTER_DATE_TO = 'date_to';
    const FILTER_EQUIPMENT = 'equipment_id';
    const FILTER_USER = 'user_id';
}