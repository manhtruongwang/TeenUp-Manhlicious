import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Clock, User, Users } from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Student Management',
        href: '/student-management',
    },
];

interface Parent {
    id: number;
    name: string;
    phone: string;
    email: string;
}

interface Student {
    id: number;
    name: string;
    dob: string;
    gender: string;
    current_grade: string;
    parent_id: number;
    parent?: Parent;
}

interface Class {
    id: number;
    name: string;
    subject: string;
    day_of_week: string;
    time_slot: string;
    teacher_name: string;
    max_students: number;
    class_registrations_count: number;
}

interface ClassRegistration {
    id: number;
    class_id: number;
    student_id: number;
    class?: Class;
    student?: Student;
}

export default function StudentManagement() {
    const [parents, setParents] = useState<Parent[]>([]);
    const [students, setStudents] = useState<Student[]>([]);
    const [classes, setClasses] = useState<Class[]>([]);
    const [loading, setLoading] = useState(false);

    // Form states
    const [parentForm, setParentForm] = useState({
        name: '',
        phone: '',
        email: '',
    });

    const [studentForm, setStudentForm] = useState({
        name: '',
        dob: '',
        gender: '',
        current_grade: '',
        parent_id: '',
    });

    const [registrationForm, setRegistrationForm] = useState({
        student_id: '',
        class_id: '',
    });

    const daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    const grades = ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'];

    // Load data on component mount
    useEffect(() => {
        loadData();
    }, []);

    const loadData = async () => {
        setLoading(true);
        try {
            console.log('Loading data...');

            // Load classes
            const classesResponse = await fetch('/api/classes');
            console.log('Classes response:', classesResponse);
            if (!classesResponse.ok) {
                throw new Error(`Classes API error: ${classesResponse.status}`);
            }
            const classesData = await classesResponse.json();
            console.log('Classes data:', classesData);
            setClasses(classesData.data || []);

            // Load students
            const studentsResponse = await fetch('/api/students');
            console.log('Students response:', studentsResponse);
            if (!studentsResponse.ok) {
                throw new Error(`Students API error: ${studentsResponse.status}`);
            }
            const studentsData = await studentsResponse.json();
            console.log('Students data:', studentsData);
            setStudents(studentsData.data || []);

            // Load parents
            const parentsResponse = await fetch('/api/parents');
            console.log('Parents response:', parentsResponse);
            if (!parentsResponse.ok) {
                throw new Error(`Parents API error: ${parentsResponse.status}`);
            }
            const parentsData = await parentsResponse.json();
            console.log('Parents data:', parentsData);
            setParents(parentsData.data || []);

        } catch (error) {
            console.error('Error loading data:', error);
            toast.error(`Failed to load data: ${error instanceof Error ? error.message : 'Unknown error'}`);
        } finally {
            setLoading(false);
        }
    };

    const handleParentSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await fetch('/api/parents', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(parentForm),
            });

            const data = await response.json();
            console.log('Parent creation response:', data);

            if (response.ok) {
                toast.success('Parent created successfully!');
                setParentForm({ name: '', phone: '', email: '' });
                loadData(); // Reload data to include new parent
            } else {
                toast.error(data.message || 'Failed to create parent');
            }
        } catch (error) {
            console.error('Error creating parent:', error);
            toast.error('Failed to create parent');
        } finally {
            setLoading(false);
        }
    };

    const handleStudentSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await fetch('/api/students', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    ...studentForm,
                    parent_id: parseInt(studentForm.parent_id),
                }),
            });

            const data = await response.json();
            console.log('Student creation response:', data);

            if (response.ok) {
                toast.success('Student created successfully!');
                setStudentForm({ name: '', dob: '', gender: '', current_grade: '', parent_id: '' });
                loadData(); // Reload data to include new student
            } else {
                toast.error(data.message || 'Failed to create student');
            }
        } catch (error) {
            console.error('Error creating student:', error);
            toast.error('Failed to create student');
        } finally {
            setLoading(false);
        }
    };

    const handleClassRegistration = async (classId: number, studentId: number) => {
        setLoading(true);
        try {
            console.log(`Registering student ${studentId} for class ${classId}`);
            const response = await fetch(`/api/classes/${classId}/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ student_id: studentId }),
            });

            const data = await response.json();
            console.log('Registration response:', data);

            if (response.ok) {
                toast.success('Student registered successfully!');
                loadData(); // Reload data to update class counts
            } else {
                toast.error(data.message || 'Failed to register student');
            }
        } catch (error) {
            console.error('Error registering student:', error);
            toast.error('Failed to register student');
        } finally {
            setLoading(false);
        }
    };

    const getClassesByDay = (day: string) => {
        return classes.filter(cls => cls.day_of_week === day);
    };

    const formatTimeSlot = (timeSlot: string) => {
        return timeSlot;
    };

    const getDayDisplayName = (day: string) => {
        return day.charAt(0).toUpperCase() + day.slice(1);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Student Management" />

            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                <Tabs defaultValue="forms" className="w-full">
                    <TabsList className="grid w-full grid-cols-2">
                        <TabsTrigger value="forms">Forms</TabsTrigger>
                        <TabsTrigger value="schedule">Weekly Schedule</TabsTrigger>
                    </TabsList>

                    <TabsContent value="forms" className="space-y-6">
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            {/* Parent Creation Form */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2">
                                        <User className="h-5 w-5" />
                                        Create Parent
                                    </CardTitle>
                                    <CardDescription>
                                        Add a new parent to the system
                                    </CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={handleParentSubmit} className="space-y-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="parent-name">Name</Label>
                                            <Input
                                                id="parent-name"
                                                value={parentForm.name}
                                                onChange={(e) => setParentForm({ ...parentForm, name: e.target.value })}
                                                required
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="parent-phone">Phone</Label>
                                            <Input
                                                id="parent-phone"
                                                value={parentForm.phone}
                                                onChange={(e) => setParentForm({ ...parentForm, phone: e.target.value })}
                                                required
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="parent-email">Email</Label>
                                            <Input
                                                id="parent-email"
                                                type="email"
                                                value={parentForm.email}
                                                onChange={(e) => setParentForm({ ...parentForm, email: e.target.value })}
                                                required
                                            />
                                        </div>
                                        <Button type="submit" disabled={loading} className="w-full">
                                            {loading ? 'Creating...' : 'Create Parent'}
                                        </Button>
                                    </form>
                                </CardContent>
                            </Card>

                            {/* Student Creation Form */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2">
                                        <Users className="h-5 w-5" />
                                        Create Student
                                    </CardTitle>
                                    <CardDescription>
                                        Add a new student to the system
                                    </CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={handleStudentSubmit} className="space-y-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="student-name">Name</Label>
                                            <Input
                                                id="student-name"
                                                value={studentForm.name}
                                                onChange={(e) => setStudentForm({ ...studentForm, name: e.target.value })}
                                                required
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="student-dob">Date of Birth</Label>
                                            <Input
                                                id="student-dob"
                                                type="date"
                                                value={studentForm.dob}
                                                onChange={(e) => setStudentForm({ ...studentForm, dob: e.target.value })}
                                                required
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="student-gender">Gender</Label>
                                            <Select value={studentForm.gender} onValueChange={(value) => setStudentForm({ ...studentForm, gender: value })}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select gender" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem value="male">Male</SelectItem>
                                                    <SelectItem value="female">Female</SelectItem>
                                                    <SelectItem value="other">Other</SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="student-grade">Current Grade</Label>
                                            <Select value={studentForm.current_grade} onValueChange={(value) => setStudentForm({ ...studentForm, current_grade: value })}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select grade" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {grades.map((grade) => (
                                                        <SelectItem key={grade} value={grade}>
                                                            {grade}
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="student-parent">Parent</Label>
                                            <Select value={studentForm.parent_id} onValueChange={(value) => setStudentForm({ ...studentForm, parent_id: value })}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select parent" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {parents.map((parent) => (
                                                        <SelectItem key={parent.id} value={parent.id.toString()}>
                                                            {parent.name} ({parent.email})
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <Button type="submit" disabled={loading} className="w-full">
                                            {loading ? 'Creating...' : 'Create Student'}
                                        </Button>
                                    </form>
                                </CardContent>
                            </Card>
                        </div>
                    </TabsContent>

                    <TabsContent value="schedule" className="space-y-6">
                        {/* Weekly Schedule */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <Clock className="h-5 w-5" />
                                    Weekly Class Schedule
                                </CardTitle>
                                <CardDescription>
                                    View and register students for classes
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-4">
                                    {daysOfWeek.map((day) => (
                                        <div key={day} className="space-y-3">
                                            <h3 className="font-semibold text-center text-sm uppercase tracking-wide">
                                                {getDayDisplayName(day)}
                                            </h3>
                                            <div className="space-y-2">
                                                {getClassesByDay(day).map((cls) => (
                                                    <Card key={cls.id} className="p-3 min-h-52">
                                                        <div className="space-y-2">
                                                            <div className="font-medium text-sm">{cls.name}</div>
                                                            <div className="text-xs text-muted-foreground">
                                                                {cls.subject}
                                                            </div>
                                                            <div className="text-xs text-muted-foreground">
                                                                {formatTimeSlot(cls.time_slot)}
                                                            </div>
                                                            <div className="text-xs text-muted-foreground">
                                                                Teacher: {cls.teacher_name}
                                                            </div>
                                                            <div className="flex items-center justify-between gap-2">
                                                                <Badge variant="secondary" className="text-xs">
                                                                    {cls.class_registrations_count}/{cls.max_students}
                                                                </Badge>
                                                                <Dialog>
                                                                    <DialogTrigger asChild>
                                                                        <Button size="sm" variant="outline" className="text-xs">
                                                                            Register
                                                                        </Button>
                                                                    </DialogTrigger>
                                                                    <DialogContent>
                                                                        <DialogHeader>
                                                                            <DialogTitle>Register Student for {cls.name}</DialogTitle>
                                                                            <DialogDescription>
                                                                                Select a student to register for this class
                                                                            </DialogDescription>
                                                                        </DialogHeader>
                                                                        <div className="space-y-4">
                                                                            <div className="space-y-2">
                                                                                <Label>Select Student</Label>
                                                                                <Select onValueChange={(value) => handleClassRegistration(cls.id, parseInt(value))}>
                                                                                    <SelectTrigger>
                                                                                        <SelectValue placeholder="Choose a student" />
                                                                                    </SelectTrigger>
                                                                                    <SelectContent>
                                                                                        {students.map((student) => (
                                                                                            <SelectItem key={student.id} value={student.id.toString()}>
                                                                                                {student.name} - {student.current_grade}
                                                                                            </SelectItem>
                                                                                        ))}
                                                                                    </SelectContent>
                                                                                </Select>
                                                                            </div>
                                                                        </div>
                                                                    </DialogContent>
                                                                </Dialog>
                                                            </div>
                                                        </div>
                                                    </Card>
                                                ))}
                                                {getClassesByDay(day).length === 0 && (
                                                    <div className="text-center text-sm text-muted-foreground py-4">
                                                        No classes
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </AppLayout>
    );
} 