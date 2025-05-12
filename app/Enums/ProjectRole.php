<?php

namespace App\Enums;

enum ProjectRole: string
{
    case None = 'None';
    case Admin = 'Admin';
    case ProjectManager = 'Project Manager';
    case UIDesigner = 'UI Designer';   
    case FrontendDeveloper = 'Frontend Developer';
    case BackendDeveloper = 'Backend Developer';
    case FullstackDeveloper = 'Fullstack Developer';
    case QAEngineer = 'QA Engineer';
    case DevOpsEngineer = 'DevOps Engineer';
    case ScrumMaster = 'Scrum Master';
    case ProductOwner = 'Product Owner';
    case BusinessAnalyst = 'Business Analyst';
    case TechnicalWriter = 'Technical Writer';
    case DatabaseAdministrator = 'Database Administrator';
}
