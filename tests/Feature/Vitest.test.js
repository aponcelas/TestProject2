import { describe, test, expect } from 'vitest';
import axios from 'axios';

describe('test the route to get all users', () => {
  test('should return all users', async () => {
    try {
      const response = await axios.get('/users');
      expect(response.status).toBe(200);
      expect(response.headers['content-type']).toContain('application/json');
      expect(response.data.length).toBeGreaterThan(0);
    } catch (error) {
      console.error('Error:', error);
    }
  });
});